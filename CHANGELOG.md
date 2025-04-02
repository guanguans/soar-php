<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="6.0.1"></a>
## [6.0.1] - 2025-04-03
### Bug Fixes
- **AddHasOptionsDocCommentRector:** Update doc comments to use '//' for descriptions
- **rector:** Handle null key in refactor method

### Build
- **dependencies:** Restore ext-ctype and ext-mbstring requirements

### CI
- **support:** Add checkSoarBinary script to validate executable files
- **workflows:** Add workflow_dispatch to all workflow files

### Code Refactoring
- **core:** Replace create() with make() in multiple files
- **options:** Rename onlyDsns method to onlyDsn

### Tests
- **fixtures:** Remove obsolete Soar.php and update .gitignore
- **phpunit:** Update PHPUnit configuration and add HelpersTest


<a name="6.0.0"></a>
## [6.0.0] - 2025-04-01
### Bug Fixes
- Update Composer scripts and remove documentation clutter
- **ConcreteMagic:** Correct static instantiation in __set_state
- **concerns:** Use JSON_THROW_ON_ERROR in arrayScores method
- **tests:** Refine parameter checks and improve code clarity

### Build
- **dependencies:** Refactor dependency exclusions and requirements

### CI
- **baselines:** Add new baseline files for error tracking
- **composer:** Update dev-master branch alias to 6.x-dev
- **config:** Remove disallowed.function.neon and clean loader
- **config:** Update .gitattributes and remove psalm workflow
- **issue-template:** Add bug report and config templates
- **workflows:** Upgrade PHP version to 8.0 in workflows and docs

### Code Refactoring
- Remove array_reduce_with_keys function and simplify code
- Remove unused escape_argument function calls
- Replace str_camel with IlluminateSupportStr methods
- Replace setReportType with withReportType methods
- Rename and update rector classes for clarity
- **Concerns:** Simplify __call method options handling
- **HasOptions:** Rename remove methods to except
- **HasOptions:** Rename parameter in magic __call method
- **HasOptions:** Rename 'withOptions' to 'mergeOptions'
- **HasOptions:** Simplify DSN construction logic
- **HasOptions:** Rename key to name in option methods
- **OS:** Simplify OS class methods and remove stale properties
- **WithRunable:** Simplify type hints in run methods
- **WithRunable:** Simplify process creation logic
- **WithRunable:** Simplify run and createProcess methods
- **composer:** Update PHP and package requirements
- **concerns:** Simplify process handling in WithRunable trait
- **option-management:** Remove add option methods
- **options:** Rename merge methods to with for clarity
- **options:** Improve option normalization logic
- **options:** Simplify normalization of options handling
- **options:** Enhance configuration structure and defaults
- **options:** Improve delimiter handling in scores method
- **options:** Change methods to private visibility
- **support:** Rename dump scripts and improve config handling
- **tests:** Remove obsolete options.full.php reference

### Docs
- **README:** Update version option methods in examples

### Features
- **HasOptions:** Add addr construction for DSN missing addr
- **HasOptions:** Add HasOptionsDocCommentRector for generating doc comments
- **HasOptions:** Add flushOptions method to reset options
- **config:** Add soar options configuration and scripts
- **hasOptions:** Implement ArrayAccess methods for options
- **rectors:** Add SimplifyArrayKeyRector for array key simplification

### Performance Improvements
- **core:** Upgrade PHPStan level and type hints in codebase

### Tests
- **HasOptions:** Refactor option tests and add new cases
- **HasSoarBinary:** Add tests for invalid binary file scenarios
- **WithRunnableTest:** Improve error message and refactor tests
- **tests:** Add snapshot assertion for version output
- **tests:** Add static analysis suppressions in test files


<a name="5.1.1"></a>
## [5.1.1] - 2025-03-24
### Build
- **dependencies:** Update PHP dependencies in composer.json


<a name="5.1.0"></a>
## [5.1.0] - 2025-02-05
### Build
- **dependencies:** Upgrade phpstan-disallowed-calls and psalm

### Features
- **Concerns:** Add Makeable trait for object creation

### Pull Requests
- Merge pull request [#173](https://github.com/guanguans/soar-php/issues/173) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.3.0


<a name="5.0.3"></a>
## [5.0.3] - 2025-01-16
### Code Refactoring
- **WithRunable:** Simplify sudo password handling

### Docs
- **README:** Update badges for CI and versioning


<a name="5.0.2"></a>
## [5.0.2] - 2025-01-16
### CI
- **formatting:** Fix formatting issues in .php-cs-fixer.php, examples/soar.options.docblock.php, and src/Support/ComposerScript.php

### Performance Improvements
- **Concerns:** improve error handling in setSoarBinary


<a name="5.0.1"></a>
## [5.0.1] - 2025-01-16
### CI
- **composer-updater:** Fix PHPStan errors and update dependencies

### Code Refactoring
- **escape-arg:** Refactor EscapeArg class

### Features
- **ConcreteMagic:** add serialization and unserialization methods

### Performance Improvements
- **HasSoarBinary:** Improve error handling
- **commit:** Improve performance by optimizing code
- **concerns:** optimize arrayScores performance

### Tests
- **commit:** Add test files and update PHPUnit configuration


<a name="5.0.0"></a>
## [5.0.0] - 2025-01-16
### Build
- Update .gitignore, add .php-cs-fixer-dist.php, and modify composer.json, phpstan.neon, phpunit.xml.dist, psalm.xml.dist, rector.php

### CI
- apply rector
- apply php-cs-fixer
- apply php-cs-fixer
- **chglog:** update filters and title maps in .chglog/config.yml

### Features
- **upgrade:** Upgrade PHP version to 7.4


<a name="4.2.6"></a>
## [4.2.6] - 2025-01-15
### CI
- **composer:** Update dependencies

### Pull Requests
- Merge pull request [#171](https://github.com/guanguans/soar-php/issues/171) from guanguans/dependabot/github_actions/codecov/codecov-action-5


<a name="4.2.5"></a>
## [4.2.5] - 2024-10-11

<a name="4.2.4"></a>
## [4.2.4] - 2024-08-16
### Tests
- **benchmarks:** Adjust iterations in SoarBench and benchmark settings


<a name="4.2.3"></a>
## [4.2.3] - 2024-07-16
### Bug Fixes
- **HasSudoPassword:** Improve formatting of setSudoPassword method


<a name="4.2.2"></a>
## [4.2.2] - 2024-07-16
### Build
- **composer.json:** update composer-git-hooks and rector versions

### CI
- **release:** Add StaticClosureRector and update rules

### Pull Requests
- Merge pull request [#170](https://github.com/guanguans/soar-php/issues/170) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.2.0


<a name="4.2.1"></a>
## [4.2.1] - 2024-06-11
### Pull Requests
- Merge pull request [#169](https://github.com/guanguans/soar-php/issues/169) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="4.2.0"></a>
## [4.2.0] - 2024-04-23
### Code Refactoring
- **HasSoarBinary:** rename getDefaultSoarBinary to defaultSoarBinary
- **debug:** improve debug info handling

### Features
- **composer-updater:** add dry-run option

### Pull Requests
- Merge pull request [#165](https://github.com/guanguans/soar-php/issues/165) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.0.0
- Merge pull request [#168](https://github.com/guanguans/soar-php/issues/168) from guanguans/dependabot/github_actions/codecov/codecov-action-4.3.0
- Merge pull request [#167](https://github.com/guanguans/soar-php/issues/167) from guanguans/dependabot/github_actions/codecov/codecov-action-4.2.0
- Merge pull request [#166](https://github.com/guanguans/soar-php/issues/166) from guanguans/dependabot/github_actions/codecov/codecov-action-4.1.1
- Merge pull request [#164](https://github.com/guanguans/soar-php/issues/164) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.7.0
- Merge pull request [#163](https://github.com/guanguans/soar-php/issues/163) from guanguans/dependabot/github_actions/codecov/codecov-action-4.1.0
- Merge pull request [#162](https://github.com/guanguans/soar-php/issues/162) from guanguans/dependabot/github_actions/codecov/codecov-action-4.0.2


<a name="4.1.0"></a>
## [4.1.0] - 2024-02-22
### Code Refactoring
- **src:** Improve __debugInfo method

### Pull Requests
- Merge pull request [#160](https://github.com/guanguans/soar-php/issues/160) from guanguans/dependabot/github_actions/codecov/codecov-action-4.0.1
- Merge pull request [#161](https://github.com/guanguans/soar-php/issues/161) from guanguans/dependabot/composer/rector/rector-tw-0.19or-tw-1.0
- Merge pull request [#158](https://github.com/guanguans/soar-php/issues/158) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.6


<a name="4.0.3"></a>
## [4.0.3] - 2024-01-29
### Bug Fixes
- **HasSudoPassword:** Update shouldApplySudoPassword condition

### Code Refactoring
- **config:** update PHPUnit set and add new rule

### Pull Requests
- Merge pull request [#156](https://github.com/guanguans/soar-php/issues/156) from guanguans/dependabot/github_actions/actions/cache-4
- Merge pull request [#157](https://github.com/guanguans/soar-php/issues/157) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.5


<a name="4.0.2"></a>
## [4.0.2] - 2024-01-16
### Code Refactoring
- **concerns:** improve magic methods

### Docs
- Update README.md and README-zh_CN.md

### Features
- **composer:** add dump-soar command


<a name="4.0.1"></a>
## [4.0.1] - 2024-01-16
### Tests
- add snapshot update command
- refactor test
- refactor test
- refactor test
- refactor test
- replace phpunit -> pest


<a name="4.0.0"></a>
## [4.0.0] - 2024-01-15
### Code Refactoring
- rename SoarPath -> SoarBinary
- **WithRunable:** remove deprecated exec method


<a name="3.5.0"></a>
## [3.5.0] - 2024-01-15
### Code Refactoring
- **monorepo-builder:** update release workers

### Pull Requests
- Merge pull request [#155](https://github.com/guanguans/soar-php/issues/155) from guanguans/dependabot/composer/rector/rector-tw-0.18or-tw-0.19
- Merge pull request [#154](https://github.com/guanguans/soar-php/issues/154) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#153](https://github.com/guanguans/soar-php/issues/153) from guanguans/dependabot/github_actions/actions/labeler-5
- Merge pull request [#152](https://github.com/guanguans/soar-php/issues/152) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5


<a name="3.4.4"></a>
## [3.4.4] - 2023-09-15
### Bug Fixes
- **HasOptions:** handle callable values in normalizeOption

### Code Refactoring
- **coding-style:** remove UnSpreadOperatorRector

### Pull Requests
- Merge pull request [#151](https://github.com/guanguans/soar-php/issues/151) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.4.3"></a>
## [3.4.3] - 2023-08-22
### Bug Fixes
- **phpstan:** Ignore errors in Soar.php

### Pull Requests
- Merge pull request [#149](https://github.com/guanguans/soar-php/issues/149) from guanguans/dependabot/composer/rector/rector-tw-0.17or-tw-0.18


<a name="3.4.2"></a>
## [3.4.2] - 2023-07-30
### Bug Fixes
- **concerns:** deprecate exec method


<a name="3.4.1"></a>
## [3.4.1] - 2023-07-24
### Bug Fixes
- **Concerns:** Fix InvalidOptionException in ConcreteMagic trait

### Code Refactoring
- **WithRunable:** simplify process tapper logic


<a name="3.4.0"></a>
## [3.4.0] - 2023-07-23
### Bug Fixes
- **concerns:** Update Soar path for Linux ARM64
- **path:** update Soar path for linux-amd64

### Features
- **bin:** Add support for Linux ARM64 architecture
- **monorepo-builder:** Add monorepo-builder configuration


<a name="v3.3.4"></a>
## [v3.3.4] - 2023-07-16
### Code Refactoring
- **HasOptions:** update onlyOptions method


<a name="v3.3.3"></a>
## [v3.3.3] - 2023-07-16
### Bug Fixes
- **HasSoarPath:** Add getEscapedSoarPath method

### Code Refactoring
- **HasOptions:** change access modifiers of methods
- **HasOptions:** rename method getSerializedEscapedNormalizedOptions to getHydratedEscapedNormalizedOptions

### Features
- **lint:** Add json-lint and yaml-lint checks


<a name="v3.3.2"></a>
## [v3.3.2] - 2023-07-15
### Bug Fixes
- **workflows:** update php-cs-fixer workflow

### Code Refactoring
- **HasOptions:** update getSerializedEscapedNormalizedOptions method
- **rector:** remove unused imports and update rules


<a name="v3.3.1"></a>
## [v3.3.1] - 2023-07-14
### Code Refactoring
- **HasSudoPassword:** improve escaping of sudo password

### Docs
- **README.md:** add section for fatal error and its fix

### Features
- **tests:** Add new test file for SudoPassword


<a name="v3.3.0"></a>
## [v3.3.0] - 2023-07-14
### Code Refactoring
- **concerns:** update getEscapeSudoPassword method
- **concerns:** update shouldApplySudoPassword logic
- **sudo:** move sudo password related methods to trait

### Features
- **HasSudoPassword:** Add new trait

### Pull Requests
- Merge pull request [#148](https://github.com/guanguans/soar-php/issues/148) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.6.0


<a name="v3.2.7"></a>
## [v3.2.7] - 2023-06-17

<a name="v3.2.6"></a>
## [v3.2.6] - 2023-06-16
### Pull Requests
- Merge pull request [#146](https://github.com/guanguans/soar-php/issues/146) from guanguans/dependabot/composer/rector/rector-tw-0.16or-tw-0.17
- Merge pull request [#147](https://github.com/guanguans/soar-php/issues/147) from guanguans/dependabot/composer/dms/phpunit-arraysubset-asserts-tw-0.4or-tw-0.5


<a name="v3.2.5"></a>
## [v3.2.5] - 2023-05-27

<a name="v3.2.4"></a>
## [v3.2.4] - 2023-05-26

<a name="v3.2.3"></a>
## [v3.2.3] - 2023-05-26
### Pull Requests
- Merge pull request [#145](https://github.com/guanguans/soar-php/issues/145) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.5.1
- Merge pull request [#144](https://github.com/guanguans/soar-php/issues/144) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.5.0


<a name="v3.2.2"></a>
## [v3.2.2] - 2023-05-22

<a name="v3.2.1"></a>
## [v3.2.1] - 2023-05-21

<a name="v3.2.0"></a>
## [v3.2.0] - 2023-05-21

<a name="v3.1.1"></a>
## [v3.1.1] - 2023-05-19

<a name="v3.1.0"></a>
## [v3.1.0] - 2023-05-19
### Pull Requests
- Merge pull request [#142](https://github.com/guanguans/soar-php/issues/142) from guanguans/dependabot/composer/rector/rector-tw-0.15.7or-tw-0.16.0
- Merge pull request [#138](https://github.com/guanguans/soar-php/issues/138) from guanguans/dependabot/github_actions/actions/stale-8
- Merge pull request [#143](https://github.com/guanguans/soar-php/issues/143) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.4
- Merge pull request [#141](https://github.com/guanguans/soar-php/issues/141) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.3
- Merge pull request [#140](https://github.com/guanguans/soar-php/issues/140) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.4.0
- Merge pull request [#139](https://github.com/guanguans/soar-php/issues/139) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.2
- Merge pull request [#137](https://github.com/guanguans/soar-php/issues/137) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-1.3.6


<a name="v3.0.7"></a>
## [v3.0.7] - 2023-01-17

<a name="v3.0.6"></a>
## [v3.0.6] - 2023-01-16

<a name="v3.0.5"></a>
## [v3.0.5] - 2023-01-15

<a name="v3.0.4"></a>
## [v3.0.4] - 2023-01-14

<a name="v3.0.3"></a>
## [v3.0.3] - 2023-01-14

<a name="v3.0.2"></a>
## [v3.0.2] - 2023-01-13

<a name="v3.0.1"></a>
## [v3.0.1] - 2023-01-12

<a name="v3.0.0"></a>
## [v3.0.0] - 2023-01-12

<a name="v2.7.8"></a>
## [v2.7.8] - 2023-01-10

<a name="v2.7.7"></a>
## [v2.7.7] - 2023-01-10

<a name="v2.7.6"></a>
## [v2.7.6] - 2023-01-10

<a name="v2.7.5"></a>
## [v2.7.5] - 2023-01-10

<a name="v2.7.4"></a>
## [v2.7.4] - 2023-01-10

<a name="v2.7.3"></a>
## [v2.7.3] - 2023-01-09

<a name="v2.7.2"></a>
## [v2.7.2] - 2023-01-08

<a name="v2.7.1"></a>
## [v2.7.1] - 2023-01-06

<a name="v2.7.0"></a>
## [v2.7.0] - 2023-01-05

<a name="v2.6.2"></a>
## [v2.6.2] - 2023-01-05
### Pull Requests
- Merge pull request [#136](https://github.com/guanguans/soar-php/issues/136) from guanguans/dependabot/github_actions/actions/stale-7
- Merge pull request [#135](https://github.com/guanguans/soar-php/issues/135) from guanguans/dependabot/composer/vimeo/psalm-tw-4.0or-tw-5.0
- Merge pull request [#134](https://github.com/guanguans/soar-php/issues/134) from guanguans/dependabot/github_actions/actions/stale-6
- Merge pull request [#133](https://github.com/guanguans/soar-php/issues/133) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.1


<a name="v2.6.1"></a>
## [v2.6.1] - 2022-05-25

<a name="v2.6.0"></a>
## [v2.6.0] - 2022-04-29
### Pull Requests
- Merge pull request [#132](https://github.com/guanguans/soar-php/issues/132) from guanguans/process


<a name="v2.5.8"></a>
## [v2.5.8] - 2022-04-28
### Pull Requests
- Merge pull request [#131](https://github.com/guanguans/soar-php/issues/131) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.0


<a name="v2.5.7"></a>
## [v2.5.7] - 2022-04-19

<a name="v2.5.6"></a>
## [v2.5.6] - 2022-04-19

<a name="v2.5.5"></a>
## [v2.5.5] - 2022-04-17

<a name="v2.5.4"></a>
## [v2.5.4] - 2022-04-16

<a name="v2.5.3"></a>
## [v2.5.3] - 2022-04-16
### Pull Requests
- Merge pull request [#130](https://github.com/guanguans/soar-php/issues/130) from guanguans/dependabot/github_actions/codecov/codecov-action-3.0.0
- Merge pull request [#129](https://github.com/guanguans/soar-php/issues/129) from guanguans/dependabot/github_actions/actions/cache-3


<a name="v2.5.2"></a>
## [v2.5.2] - 2022-04-11

<a name="v2.5.1"></a>
## [v2.5.1] - 2022-04-11

<a name="v2.5.0"></a>
## [v2.5.0] - 2022-04-11

<a name="v2.4.1"></a>
## [v2.4.1] - 2022-04-11

<a name="v2.4.0"></a>
## [v2.4.0] - 2022-04-10

<a name="v2.3.0"></a>
## [v2.3.0] - 2022-03-27

<a name="v2.2.7"></a>
## [v2.2.7] - 2021-11-30

<a name="v2.2.6"></a>
## [v2.2.6] - 2021-09-28

<a name="v2.2.5"></a>
## [v2.2.5] - 2021-09-28

<a name="v2.2.4"></a>
## [v2.2.4] - 2021-09-27
### Docs
- update .all-contributorsrc [skip ci]
- update README-EN.md [skip ci]
- update README.md [skip ci]
- update .all-contributorsrc [skip ci]
- update README-EN.md [skip ci]
- update README.md [skip ci]

### Pull Requests
- Merge pull request [#42](https://github.com/guanguans/soar-php/issues/42) from guanguans/all-contributors/add-Aexus
- Merge pull request [#41](https://github.com/guanguans/soar-php/issues/41) from guanguans/all-contributors/add-zhonghaibin
- Merge pull request [#40](https://github.com/guanguans/soar-php/issues/40) from guanguans/dependabot/composer/vimeo/psalm-tw-3.11or-tw-4.0
- Merge pull request [#39](https://github.com/guanguans/soar-php/issues/39) from guanguans/analysis-nNPjG0
- Merge pull request [#38](https://github.com/guanguans/soar-php/issues/38) from zhonghaibin/master


<a name="v2.2.3"></a>
## [v2.2.3] - 2021-07-07

<a name="v2.2.2"></a>
## [v2.2.2] - 2021-07-06

<a name="v2.2.1"></a>
## [v2.2.1] - 2021-06-14

<a name="v2.2.0"></a>
## [v2.2.0] - 2021-06-14

<a name="v2.1.1"></a>
## [v2.1.1] - 2021-04-29
### Build
- Update composer.json

### Docs
- Update README.md
- Update README.md

### Performance Improvements
- Remove config file init
- Delete `Services/SoarService.php`


<a name="v2.1.0"></a>
## [v2.1.0] - 2021-04-25
### CI
- Add php-cs-fixer、psalm、cghooks

### Docs
- Update README.md

### Tests
- Fix tests


<a name="v2.0.4"></a>
## [v2.0.4] - 2021-01-27
### Pull Requests
- Merge pull request [#37](https://github.com/guanguans/soar-php/issues/37) from guanguans/analysis-9magdl
- Merge pull request [#35](https://github.com/guanguans/soar-php/issues/35) from guanguans/analysis-vQY5br


<a name="v2.0.3"></a>
## [v2.0.3] - 2020-11-07
### Pull Requests
- Merge pull request [#22](https://github.com/guanguans/soar-php/issues/22) from guanguans/imgbot


<a name="v2.0.2"></a>
## [v2.0.2] - 2020-04-11
### Pull Requests
- Merge pull request [#20](https://github.com/guanguans/soar-php/issues/20) from guanguans/analysis-5Z3GP2


<a name="v2.0.1"></a>
## [v2.0.1] - 2020-02-03

<a name="v2.0.0"></a>
## [v2.0.0] - 2020-01-21
### Docs
- add huangdijia as a contributor ([#15](https://github.com/guanguans/soar-php/issues/15))
- update .all-contributorsrc
- update README-EN.md
- update README.md


<a name="v1.1.5"></a>
## [v1.1.5] - 2019-08-29

<a name="v1.1.4"></a>
## [v1.1.4] - 2019-08-29

<a name="v1.1.3"></a>
## [v1.1.3] - 2019-08-24
### Docs
- add leslieeilsel as a contributor ([#11](https://github.com/guanguans/soar-php/issues/11))
- update .all-contributorsrc
- update README.md
- add kamly as a contributor ([#10](https://github.com/guanguans/soar-php/issues/10))
- create .all-contributorsrc
- update README.md


<a name="v1.1.2"></a>
## [v1.1.2] - 2019-07-06

<a name="v1.1.1"></a>
## [v1.1.1] - 2019-07-05

<a name="v1.1.0"></a>
## [v1.1.0] - 2019-07-05

<a name="v1.0.1"></a>
## [v1.0.1] - 2019-07-04

<a name="v1.0.0"></a>
## v1.0.0 - 2019-07-04

[Unreleased]: https://github.com/guanguans/soar-php/compare/6.0.1...HEAD
[6.0.1]: https://github.com/guanguans/soar-php/compare/6.0.0...6.0.1
[6.0.0]: https://github.com/guanguans/soar-php/compare/5.1.1...6.0.0
[5.1.1]: https://github.com/guanguans/soar-php/compare/5.1.0...5.1.1
[5.1.0]: https://github.com/guanguans/soar-php/compare/5.0.3...5.1.0
[5.0.3]: https://github.com/guanguans/soar-php/compare/5.0.2...5.0.3
[5.0.2]: https://github.com/guanguans/soar-php/compare/5.0.1...5.0.2
[5.0.1]: https://github.com/guanguans/soar-php/compare/5.0.0...5.0.1
[5.0.0]: https://github.com/guanguans/soar-php/compare/4.2.6...5.0.0
[4.2.6]: https://github.com/guanguans/soar-php/compare/4.2.5...4.2.6
[4.2.5]: https://github.com/guanguans/soar-php/compare/4.2.4...4.2.5
[4.2.4]: https://github.com/guanguans/soar-php/compare/4.2.3...4.2.4
[4.2.3]: https://github.com/guanguans/soar-php/compare/4.2.2...4.2.3
[4.2.2]: https://github.com/guanguans/soar-php/compare/4.2.1...4.2.2
[4.2.1]: https://github.com/guanguans/soar-php/compare/4.2.0...4.2.1
[4.2.0]: https://github.com/guanguans/soar-php/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/guanguans/soar-php/compare/4.0.3...4.1.0
[4.0.3]: https://github.com/guanguans/soar-php/compare/4.0.2...4.0.3
[4.0.2]: https://github.com/guanguans/soar-php/compare/4.0.1...4.0.2
[4.0.1]: https://github.com/guanguans/soar-php/compare/4.0.0...4.0.1
[4.0.0]: https://github.com/guanguans/soar-php/compare/3.5.0...4.0.0
[3.5.0]: https://github.com/guanguans/soar-php/compare/3.4.4...3.5.0
[3.4.4]: https://github.com/guanguans/soar-php/compare/3.4.3...3.4.4
[3.4.3]: https://github.com/guanguans/soar-php/compare/3.4.2...3.4.3
[3.4.2]: https://github.com/guanguans/soar-php/compare/3.4.1...3.4.2
[3.4.1]: https://github.com/guanguans/soar-php/compare/3.4.0...3.4.1
[3.4.0]: https://github.com/guanguans/soar-php/compare/v3.3.4...3.4.0
[v3.3.4]: https://github.com/guanguans/soar-php/compare/v3.3.3...v3.3.4
[v3.3.3]: https://github.com/guanguans/soar-php/compare/v3.3.2...v3.3.3
[v3.3.2]: https://github.com/guanguans/soar-php/compare/v3.3.1...v3.3.2
[v3.3.1]: https://github.com/guanguans/soar-php/compare/v3.3.0...v3.3.1
[v3.3.0]: https://github.com/guanguans/soar-php/compare/v3.2.7...v3.3.0
[v3.2.7]: https://github.com/guanguans/soar-php/compare/v3.2.6...v3.2.7
[v3.2.6]: https://github.com/guanguans/soar-php/compare/v3.2.5...v3.2.6
[v3.2.5]: https://github.com/guanguans/soar-php/compare/v3.2.4...v3.2.5
[v3.2.4]: https://github.com/guanguans/soar-php/compare/v3.2.3...v3.2.4
[v3.2.3]: https://github.com/guanguans/soar-php/compare/v3.2.2...v3.2.3
[v3.2.2]: https://github.com/guanguans/soar-php/compare/v3.2.1...v3.2.2
[v3.2.1]: https://github.com/guanguans/soar-php/compare/v3.2.0...v3.2.1
[v3.2.0]: https://github.com/guanguans/soar-php/compare/v3.1.1...v3.2.0
[v3.1.1]: https://github.com/guanguans/soar-php/compare/v3.1.0...v3.1.1
[v3.1.0]: https://github.com/guanguans/soar-php/compare/v3.0.7...v3.1.0
[v3.0.7]: https://github.com/guanguans/soar-php/compare/v3.0.6...v3.0.7
[v3.0.6]: https://github.com/guanguans/soar-php/compare/v3.0.5...v3.0.6
[v3.0.5]: https://github.com/guanguans/soar-php/compare/v3.0.4...v3.0.5
[v3.0.4]: https://github.com/guanguans/soar-php/compare/v3.0.3...v3.0.4
[v3.0.3]: https://github.com/guanguans/soar-php/compare/v3.0.2...v3.0.3
[v3.0.2]: https://github.com/guanguans/soar-php/compare/v3.0.1...v3.0.2
[v3.0.1]: https://github.com/guanguans/soar-php/compare/v3.0.0...v3.0.1
[v3.0.0]: https://github.com/guanguans/soar-php/compare/v2.7.8...v3.0.0
[v2.7.8]: https://github.com/guanguans/soar-php/compare/v2.7.7...v2.7.8
[v2.7.7]: https://github.com/guanguans/soar-php/compare/v2.7.6...v2.7.7
[v2.7.6]: https://github.com/guanguans/soar-php/compare/v2.7.5...v2.7.6
[v2.7.5]: https://github.com/guanguans/soar-php/compare/v2.7.4...v2.7.5
[v2.7.4]: https://github.com/guanguans/soar-php/compare/v2.7.3...v2.7.4
[v2.7.3]: https://github.com/guanguans/soar-php/compare/v2.7.2...v2.7.3
[v2.7.2]: https://github.com/guanguans/soar-php/compare/v2.7.1...v2.7.2
[v2.7.1]: https://github.com/guanguans/soar-php/compare/v2.7.0...v2.7.1
[v2.7.0]: https://github.com/guanguans/soar-php/compare/v2.6.2...v2.7.0
[v2.6.2]: https://github.com/guanguans/soar-php/compare/v2.6.1...v2.6.2
[v2.6.1]: https://github.com/guanguans/soar-php/compare/v2.6.0...v2.6.1
[v2.6.0]: https://github.com/guanguans/soar-php/compare/v2.5.8...v2.6.0
[v2.5.8]: https://github.com/guanguans/soar-php/compare/v2.5.7...v2.5.8
[v2.5.7]: https://github.com/guanguans/soar-php/compare/v2.5.6...v2.5.7
[v2.5.6]: https://github.com/guanguans/soar-php/compare/v2.5.5...v2.5.6
[v2.5.5]: https://github.com/guanguans/soar-php/compare/v2.5.4...v2.5.5
[v2.5.4]: https://github.com/guanguans/soar-php/compare/v2.5.3...v2.5.4
[v2.5.3]: https://github.com/guanguans/soar-php/compare/v2.5.2...v2.5.3
[v2.5.2]: https://github.com/guanguans/soar-php/compare/v2.5.1...v2.5.2
[v2.5.1]: https://github.com/guanguans/soar-php/compare/v2.5.0...v2.5.1
[v2.5.0]: https://github.com/guanguans/soar-php/compare/v2.4.1...v2.5.0
[v2.4.1]: https://github.com/guanguans/soar-php/compare/v2.4.0...v2.4.1
[v2.4.0]: https://github.com/guanguans/soar-php/compare/v2.3.0...v2.4.0
[v2.3.0]: https://github.com/guanguans/soar-php/compare/v2.2.7...v2.3.0
[v2.2.7]: https://github.com/guanguans/soar-php/compare/v2.2.6...v2.2.7
[v2.2.6]: https://github.com/guanguans/soar-php/compare/v2.2.5...v2.2.6
[v2.2.5]: https://github.com/guanguans/soar-php/compare/v2.2.4...v2.2.5
[v2.2.4]: https://github.com/guanguans/soar-php/compare/v2.2.3...v2.2.4
[v2.2.3]: https://github.com/guanguans/soar-php/compare/v2.2.2...v2.2.3
[v2.2.2]: https://github.com/guanguans/soar-php/compare/v2.2.1...v2.2.2
[v2.2.1]: https://github.com/guanguans/soar-php/compare/v2.2.0...v2.2.1
[v2.2.0]: https://github.com/guanguans/soar-php/compare/v2.1.1...v2.2.0
[v2.1.1]: https://github.com/guanguans/soar-php/compare/v2.1.0...v2.1.1
[v2.1.0]: https://github.com/guanguans/soar-php/compare/v2.0.4...v2.1.0
[v2.0.4]: https://github.com/guanguans/soar-php/compare/v2.0.3...v2.0.4
[v2.0.3]: https://github.com/guanguans/soar-php/compare/v2.0.2...v2.0.3
[v2.0.2]: https://github.com/guanguans/soar-php/compare/v2.0.1...v2.0.2
[v2.0.1]: https://github.com/guanguans/soar-php/compare/v2.0.0...v2.0.1
[v2.0.0]: https://github.com/guanguans/soar-php/compare/v1.1.5...v2.0.0
[v1.1.5]: https://github.com/guanguans/soar-php/compare/v1.1.4...v1.1.5
[v1.1.4]: https://github.com/guanguans/soar-php/compare/v1.1.3...v1.1.4
[v1.1.3]: https://github.com/guanguans/soar-php/compare/v1.1.2...v1.1.3
[v1.1.2]: https://github.com/guanguans/soar-php/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/guanguans/soar-php/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/guanguans/soar-php/compare/v1.0.1...v1.1.0
[v1.0.1]: https://github.com/guanguans/soar-php/compare/v1.0.0...v1.0.1
