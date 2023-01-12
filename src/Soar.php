<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Concerns\ConcreteExplain;
use Guanguans\SoarPHP\Concerns\ConcreteListHeuristicRules;
use Guanguans\SoarPHP\Concerns\ConcreteListRewriteRules;
use Guanguans\SoarPHP\Concerns\ConcreteScore;
use Guanguans\SoarPHP\Concerns\HasOptions;
use Guanguans\SoarPHP\Concerns\WithExecutable;
use Guanguans\SoarPHP\Concerns\WithHelpConverter;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OsHelper;

class Soar implements Contracts\Soar
{
    use ConcreteExplain;
    use ConcreteListHeuristicRules;
    use ConcreteListRewriteRules;
    use ConcreteScore;
    use HasOptions;
    use WithExecutable;
    use WithHelpConverter;

    /**
     * @var string
     */
    protected $soarPath;

    /**
     * @var \Guanguans\SoarPHP\Contracts\Explainer|null
     */
    protected $explainer;

    public function __construct(array $options = [], ?string $soarPath = null, ?Contracts\Explainer $explainer = null)
    {
        $this->setOptions($options);
        $this->setSoarPath($soarPath ?? $this->getDefaultSoarPath());
        $this->setExplainer($explainer);
    }

    public static function create(array $options = [], ?string $soarPath = null, ?Contracts\Explainer $explainer = null): self
    {
        return new self($options, $soarPath, $explainer);
    }

    public function score(string $sql): string
    {
        return $this->setQuery($sql)->mustRun(array_merge([$this->soarPath], $this->normalizedOptions));
    }

    public function explain(string $sql): string
    {
        return $this
            ->setReportType('explain-digest')
            ->exec("{$this->soarPath} {$this->getNormalizedStrOptions()} << {$this->mustGetExplainer()->getNormalizedExplain($sql)}");
    }

    public function syntaxCheck(string $sql): string
    {
        return $this->run([$this->soarPath, "-query=$sql", '-only-syntax-check=true']);
    }

    public function fingerPrint(string $sql): string
    {
        return $this->mustRun([$this->soarPath, "-query=$sql", '-report-type=fingerprint']);
    }

    public function pretty(string $sql): string
    {
        return $this->mustRun([$this->soarPath, "-query=$sql", '-report-type=pretty']);
    }

    public function md2html(string $markdown): string
    {
        return $this->mustRun([$this->soarPath, "-query=$markdown", '-report-type=md2html']);
    }

    public function listHeuristicRules(): string
    {
        return $this->mustRun([$this->soarPath, $this->getNormalizedOption('-report-type'), '-list-heuristic-rules']);
    }

    public function listRewriteRules(): string
    {
        return $this->mustRun([$this->soarPath, $this->getNormalizedOption('-report-type'), '-list-rewrite-rules']);
    }

    public function listTestSqls(): string
    {
        return $this->mustRun([$this->soarPath, '-list-test-sqls']);
    }

    public function help(): string
    {
        return $this->mustRun([$this->soarPath, '--help']);
    }

    public function version(): string
    {
        return $this->mustRun([$this->soarPath, '-version']);
    }

    public function getSoarPath(): string
    {
        return $this->soarPath;
    }

    public function setSoarPath(string $soarPath): self
    {
        if (! file_exists($soarPath) || ! is_executable($soarPath)) {
            throw new InvalidArgumentException("The file($soarPath) does not exist or cannot executable.");
        }

        $this->soarPath = realpath($soarPath);

        return $this;
    }

    public function mustGetExplainer(): Contracts\Explainer
    {
        return $this->getExplainer() ?? Factory::createExplainerFromOptions($this->options);
    }

    public function getExplainer(): ?Contracts\Explainer
    {
        return $this->explainer;
    }

    public function setExplainer(?Contracts\Explainer $explainer): self
    {
        $this->explainer = $explainer;

        return $this;
    }

    protected function getDefaultSoarPath(): string
    {
        /** @noinspection NestedTernaryOperatorInspection */
        return OsHelper::isWindows()
            ? __DIR__.'/../bin/soar.windows-amd64'
            : (
                OsHelper::isMacOS()
                ? __DIR__.'/../bin/soar.darwin-amd64'
                : __DIR__.'/../bin/soar.linux-amd64'
            );
    }
}
