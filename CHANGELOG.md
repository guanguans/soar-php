<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="7.0.3"></a>
## [7.0.3] - 2025-12-24
### 🎨 Styles
- apply php-cs-fixer ([aa0b8ec](https://github.com/guanguans/soar-php/commit/aa0b8ec))
- **namespaces:** Prefix global class references with leading backslashes ([b9fd990](https://github.com/guanguans/soar-php/commit/b9fd990))

### 🤖 Continuous Integrations
- **config:** Update config files ([4002af3](https://github.com/guanguans/soar-php/commit/4002af3))
- **config:** Update config files ([441750f](https://github.com/guanguans/soar-php/commit/441750f))
- **deps:** Add new dependencies to composer.json ([f0e6e5e](https://github.com/guanguans/soar-php/commit/f0e6e5e))
- **tests:** Update PHP version in CI configuration ([a1ab5dc](https://github.com/guanguans/soar-php/commit/a1ab5dc))

### Pull Requests
- Merge pull request [#184](https://github.com/guanguans/soar-php/issues/184) from guanguans/dependabot/github_actions/actions/cache-5


<a name="7.0.2"></a>
## [7.0.2] - 2025-12-03
### ✨ Features
- **HasSudoPassword:** Add withoutSudoPassword method to clear sudo password ([2fd77fa](https://github.com/guanguans/soar-php/commit/2fd77fa))

### 🐞 Bug Fixes
- **HasSudoPassword:** Refine sudo password application condition ([842a824](https://github.com/guanguans/soar-php/commit/842a824))


<a name="7.0.1"></a>
## [7.0.1] - 2025-12-03
### ✨ Features
- **example:** Add example script for SoarPHP usage ([38433b9](https://github.com/guanguans/soar-php/commit/38433b9))

### 🐞 Bug Fixes
- **sudo:** Simplify sudo password application condition ([80bfc3f](https://github.com/guanguans/soar-php/commit/80bfc3f))

### 📖 Documents
- **README:** Add configuration instructions for sudo password ([5329bcd](https://github.com/guanguans/soar-php/commit/5329bcd))

### 💅 Code Refactorings
- **WithRunable:** Update callable types to Closure for better type safety ([59a703f](https://github.com/guanguans/soar-php/commit/59a703f))

### ✅ Tests
- **WithRunableTest:** Skip tests on macOS ([94ee75b](https://github.com/guanguans/soar-php/commit/94ee75b))

### 🤖 Continuous Integrations
- **config:** Update config files ([cc27437](https://github.com/guanguans/soar-php/commit/cc27437))
- **config:** Update composer.json and configuration files ([5305a63](https://github.com/guanguans/soar-php/commit/5305a63))


<a name="7.0.0"></a>
## [7.0.0] - 2025-11-29
### ✨ Features
- **runable:** add setPipe method to support process piping ([7be4788](https://github.com/guanguans/soar-php/commit/7be4788))

### 🎨 Styles
- apply php-cs-fixer ([3413928](https://github.com/guanguans/soar-php/commit/3413928))

### 💅 Code Refactorings
- apply inspection ([90bbdf3](https://github.com/guanguans/soar-php/commit/90bbdf3))
- rename setter methods to use 'with' prefix for clarity ([8640903](https://github.com/guanguans/soar-php/commit/8640903))
- apply phpstan ([a98c0e8](https://github.com/guanguans/soar-php/commit/a98c0e8))
- apply rector ([7012894](https://github.com/guanguans/soar-php/commit/7012894))
- **ComposerScripts:** optimize makeSymfonyStyle method ([e71e044](https://github.com/guanguans/soar-php/commit/e71e044))
- **WithRunable:** rename processTapper to tap for clarity ([31f316a](https://github.com/guanguans/soar-php/commit/31f316a))
- **binary:** rename soarBinary to binary for consistency ([6972229](https://github.com/guanguans/soar-php/commit/6972229))
- **core:** rename sqls to queries for clarity and consistency ([63741eb](https://github.com/guanguans/soar-php/commit/63741eb))
- **helpers:** update str_snake function to use hyphen delimiter ([213c975](https://github.com/guanguans/soar-php/commit/213c975))

### ✅ Tests
- **ArchTest:** enforce prohibition of debugging functions usage ([b6024f2](https://github.com/guanguans/soar-php/commit/b6024f2))

### 📦 Builds
- **polyfill:** Remove Symfony polyfill PHP82 and update analyzer and phpstan config ([e451f2d](https://github.com/guanguans/soar-php/commit/e451f2d))

### 🤖 Continuous Integrations
- **composer:** add new scripts for blade-formatter, mago, php-cs-fixer, todo-lint, and zizmor ([a1f761e](https://github.com/guanguans/soar-php/commit/a1f761e))
- **config:** Remove unused faker mappings and commented properties ([f44e52e](https://github.com/guanguans/soar-php/commit/f44e52e))
- **config:** Update config files ([ecd2502](https://github.com/guanguans/soar-php/commit/ecd2502))
- **config:** Update config files ([319bb6e](https://github.com/guanguans/soar-php/commit/319bb6e))
- **config:** Update config files ([1c32d7f](https://github.com/guanguans/soar-php/commit/1c32d7f))
- **config:** Add YAML formatter configuration and generate rule documentation ([1817898](https://github.com/guanguans/soar-php/commit/1817898))


<a name="6.3.0"></a>
## [6.3.0] - 2025-11-21
### 💅 Code Refactorings
- **docs:** Improve PHPDoc comments and code style ([ff744b1](https://github.com/guanguans/soar-php/commit/ff744b1))

### 📦 Builds
- **deps:** update development dependencies in composer.json ([5eccbb7](https://github.com/guanguans/soar-php/commit/5eccbb7))

### Pull Requests
- Merge pull request [#180](https://github.com/guanguans/soar-php/issues/180) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-7
- Merge pull request [#181](https://github.com/guanguans/soar-php/issues/181) from guanguans/dependabot/github_actions/actions/setup-node-6
- Merge pull request [#182](https://github.com/guanguans/soar-php/issues/182) from guanguans/dependabot/github_actions/actions/checkout-6
- Merge pull request [#176](https://github.com/guanguans/soar-php/issues/176) from guanguans/dependabot/github_actions/actions/checkout-5
- Merge pull request [#175](https://github.com/guanguans/soar-php/issues/175) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-6


<a name="6.2.0"></a>
## [6.2.0] - 2025-05-23
### ✨ Features
- **soar:** Add callback parameter to scores, help, and version ([2cbad1e](https://github.com/guanguans/soar-php/commit/2cbad1e))

### Pull Requests
- Merge pull request [#174](https://github.com/guanguans/soar-php/issues/174) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.4.0


<a name="6.1.0"></a>
## [6.1.0] - 2025-05-08
### ✨ Features
- **HasOptions:** Add 'get' method support for dynamic options ([f9fe254](https://github.com/guanguans/soar-php/commit/f9fe254))

### 📖 Documents
- **contributors:** Update contributor profiles and files ([9110b6a](https://github.com/guanguans/soar-php/commit/9110b6a))

### 💅 Code Refactorings
- **docs:** Update installation command and change method visibility ([835876e](https://github.com/guanguans/soar-php/commit/835876e))

### 📦 Builds
- **Concerns:** Update todo comment in ConcreteScores trait ([df804b2](https://github.com/guanguans/soar-php/commit/df804b2))
- **config:** Update .editorconfig and .gitattributes files ([c5a5c3d](https://github.com/guanguans/soar-php/commit/c5a5c3d))
- **deps:** Update package versions and improve composer script ([0fc5a35](https://github.com/guanguans/soar-php/commit/0fc5a35))


<a name="6.0.4"></a>
## [6.0.4] - 2025-04-05
### 🐞 Bug Fixes
- **SimplifyListIndexRector:** Refactor key handling logic ([8b9ec75](https://github.com/guanguans/soar-php/commit/8b9ec75))

### 📖 Documents
- **readme:** Remove soar help section from README ([7e8e07a](https://github.com/guanguans/soar-php/commit/7e8e07a))

### 📦 Builds
- **composer.json:** Update composer command aliases ([8fdce34](https://github.com/guanguans/soar-php/commit/8fdce34))

### 🤖 Continuous Integrations
- **config:** Update changelog configuration options ([aaffea5](https://github.com/guanguans/soar-php/commit/aaffea5))
- **workflow:** Add secrets check workflow ([82849c9](https://github.com/guanguans/soar-php/commit/82849c9))


<a name="6.0.3"></a>
## [6.0.3] - 2025-04-04
### 🐞 Bug Fixes
- **options:** Correct host and port handling in DSN normalization ([55e707b](https://github.com/guanguans/soar-php/commit/55e707b))
- **tests:** Correct option normalization and query syntax ([cda80f6](https://github.com/guanguans/soar-php/commit/cda80f6))

### 📖 Documents
- **README:** Update example commands for Soar usage ([b66dee3](https://github.com/guanguans/soar-php/commit/b66dee3))

### 💅 Code Refactorings
- **scripts:** Rename dump-soar-yaml-config to dump-soar-config ([43c72cf](https://github.com/guanguans/soar-php/commit/43c72cf))
- **tests:** Update version and compilation details ([aa3dc02](https://github.com/guanguans/soar-php/commit/aa3dc02))


<a name="6.0.2"></a>
## [6.0.2] - 2025-04-03
### 🐞 Bug Fixes
- **Soar:** Improve error handling in help method ([6b65893](https://github.com/guanguans/soar-php/commit/6b65893))
- **config:** Update database configuration and add parameters ([675eadf](https://github.com/guanguans/soar-php/commit/675eadf))

### 📖 Documents
- **README:** Update description and translation accuracy ([0f1c0a4](https://github.com/guanguans/soar-php/commit/0f1c0a4))
- **changelog:** Enhance changelog template formatting ([384081d](https://github.com/guanguans/soar-php/commit/384081d))


<a name="6.0.1"></a>
## [6.0.1] - 2025-04-03
### 🐞 Bug Fixes
- **AddHasOptionsDocCommentRector:** Update doc comments to use '//' for descriptions ([b2931b9](https://github.com/guanguans/soar-php/commit/b2931b9))
- **rector:** Handle null key in refactor method ([c42d81a](https://github.com/guanguans/soar-php/commit/c42d81a))

### 💅 Code Refactorings
- **core:** Replace create() with make() in multiple files ([f3ea1d2](https://github.com/guanguans/soar-php/commit/f3ea1d2))
- **options:** Rename onlyDsns method to onlyDsn ([a459b8e](https://github.com/guanguans/soar-php/commit/a459b8e))

### ✅ Tests
- **fixtures:** Remove obsolete Soar.php and update .gitignore ([26d8c9b](https://github.com/guanguans/soar-php/commit/26d8c9b))
- **phpunit:** Update PHPUnit configuration and add HelpersTest ([f1afb0c](https://github.com/guanguans/soar-php/commit/f1afb0c))

### 📦 Builds
- **dependencies:** Restore ext-ctype and ext-mbstring requirements ([9c109ea](https://github.com/guanguans/soar-php/commit/9c109ea))

### 🤖 Continuous Integrations
- **support:** Add checkSoarBinary script to validate executable files ([904933d](https://github.com/guanguans/soar-php/commit/904933d))
- **workflows:** Add workflow_dispatch to all workflow files ([d5817f2](https://github.com/guanguans/soar-php/commit/d5817f2))


<a name="6.0.0"></a>
## [6.0.0] - 2025-04-01
### ✨ Features
- **HasOptions:** Add addr construction for DSN missing addr ([56f411c](https://github.com/guanguans/soar-php/commit/56f411c))
- **HasOptions:** Add HasOptionsDocCommentRector for generating doc comments ([5a82fae](https://github.com/guanguans/soar-php/commit/5a82fae))
- **HasOptions:** Add flushOptions method to reset options ([551103e](https://github.com/guanguans/soar-php/commit/551103e))
- **config:** Add soar options configuration and scripts ([5ebb40f](https://github.com/guanguans/soar-php/commit/5ebb40f))
- **hasOptions:** Implement ArrayAccess methods for options ([9fd1a16](https://github.com/guanguans/soar-php/commit/9fd1a16))
- **rectors:** Add SimplifyArrayKeyRector for array key simplification ([9691a8b](https://github.com/guanguans/soar-php/commit/9691a8b))

### 🐞 Bug Fixes
- Update Composer scripts and remove documentation clutter ([6b81205](https://github.com/guanguans/soar-php/commit/6b81205))
- **ConcreteMagic:** Correct static instantiation in __set_state ([a1c795d](https://github.com/guanguans/soar-php/commit/a1c795d))
- **concerns:** Use JSON_THROW_ON_ERROR in arrayScores method ([3c094a0](https://github.com/guanguans/soar-php/commit/3c094a0))
- **tests:** Refine parameter checks and improve code clarity ([8e1a1d6](https://github.com/guanguans/soar-php/commit/8e1a1d6))

### 📖 Documents
- **README:** Update version option methods in examples ([4c36da5](https://github.com/guanguans/soar-php/commit/4c36da5))

### 💅 Code Refactorings
- Remove array_reduce_with_keys function and simplify code ([786aeb2](https://github.com/guanguans/soar-php/commit/786aeb2))
- Remove unused escape_argument function calls ([62beb5e](https://github.com/guanguans/soar-php/commit/62beb5e))
- Replace str_camel with IlluminateSupportStr methods ([4e5257e](https://github.com/guanguans/soar-php/commit/4e5257e))
- Replace setReportType with withReportType methods ([153fff0](https://github.com/guanguans/soar-php/commit/153fff0))
- Rename and update rector classes for clarity ([66c0bd0](https://github.com/guanguans/soar-php/commit/66c0bd0))
- **Concerns:** Simplify __call method options handling ([c7ff596](https://github.com/guanguans/soar-php/commit/c7ff596))
- **HasOptions:** Rename remove methods to except ([0850e26](https://github.com/guanguans/soar-php/commit/0850e26))
- **HasOptions:** Rename parameter in magic __call method ([961a7fe](https://github.com/guanguans/soar-php/commit/961a7fe))
- **HasOptions:** Rename 'withOptions' to 'mergeOptions' ([219249b](https://github.com/guanguans/soar-php/commit/219249b))
- **HasOptions:** Simplify DSN construction logic ([fb6ae67](https://github.com/guanguans/soar-php/commit/fb6ae67))
- **HasOptions:** Rename key to name in option methods ([febfebc](https://github.com/guanguans/soar-php/commit/febfebc))
- **OS:** Simplify OS class methods and remove stale properties ([7015975](https://github.com/guanguans/soar-php/commit/7015975))
- **WithRunable:** Simplify type hints in run methods ([3d96f3a](https://github.com/guanguans/soar-php/commit/3d96f3a))
- **WithRunable:** Simplify process creation logic ([6753348](https://github.com/guanguans/soar-php/commit/6753348))
- **WithRunable:** Simplify run and createProcess methods ([a2731a3](https://github.com/guanguans/soar-php/commit/a2731a3))
- **composer:** Update PHP and package requirements ([c9fcd32](https://github.com/guanguans/soar-php/commit/c9fcd32))
- **concerns:** Simplify process handling in WithRunable trait ([da51782](https://github.com/guanguans/soar-php/commit/da51782))
- **option-management:** Remove add option methods ([b62e04c](https://github.com/guanguans/soar-php/commit/b62e04c))
- **options:** Rename merge methods to with for clarity ([b43d4c9](https://github.com/guanguans/soar-php/commit/b43d4c9))
- **options:** Improve option normalization logic ([a5dc6a5](https://github.com/guanguans/soar-php/commit/a5dc6a5))
- **options:** Simplify normalization of options handling ([310a26f](https://github.com/guanguans/soar-php/commit/310a26f))
- **options:** Enhance configuration structure and defaults ([5323bc9](https://github.com/guanguans/soar-php/commit/5323bc9))
- **options:** Improve delimiter handling in scores method ([b2fda32](https://github.com/guanguans/soar-php/commit/b2fda32))
- **options:** Change methods to private visibility ([6863f9f](https://github.com/guanguans/soar-php/commit/6863f9f))
- **support:** Rename dump scripts and improve config handling ([5a80f62](https://github.com/guanguans/soar-php/commit/5a80f62))
- **tests:** Remove obsolete options.full.php reference ([ccf4123](https://github.com/guanguans/soar-php/commit/ccf4123))

### 🏎 Performance Improvements
- **core:** Upgrade PHPStan level and type hints in codebase ([5fba139](https://github.com/guanguans/soar-php/commit/5fba139))

### ✅ Tests
- **HasOptions:** Refactor option tests and add new cases ([63b9e41](https://github.com/guanguans/soar-php/commit/63b9e41))
- **HasSoarBinary:** Add tests for invalid binary file scenarios ([5b18333](https://github.com/guanguans/soar-php/commit/5b18333))
- **WithRunnableTest:** Improve error message and refactor tests ([7e5024b](https://github.com/guanguans/soar-php/commit/7e5024b))
- **tests:** Add snapshot assertion for version output ([559777f](https://github.com/guanguans/soar-php/commit/559777f))
- **tests:** Add static analysis suppressions in test files ([b6bcdf8](https://github.com/guanguans/soar-php/commit/b6bcdf8))

### 📦 Builds
- **dependencies:** Refactor dependency exclusions and requirements ([a99bc4d](https://github.com/guanguans/soar-php/commit/a99bc4d))

### 🤖 Continuous Integrations
- **baselines:** Add new baseline files for error tracking ([52e5932](https://github.com/guanguans/soar-php/commit/52e5932))
- **composer:** Update dev-master branch alias to 6.x-dev ([8ab10ef](https://github.com/guanguans/soar-php/commit/8ab10ef))
- **config:** Remove disallowed.function.neon and clean loader ([3203690](https://github.com/guanguans/soar-php/commit/3203690))
- **config:** Update .gitattributes and remove psalm workflow ([85a6069](https://github.com/guanguans/soar-php/commit/85a6069))
- **issue-template:** Add bug report and config templates ([be6ac88](https://github.com/guanguans/soar-php/commit/be6ac88))
- **workflows:** Upgrade PHP version to 8.0 in workflows and docs ([0af6eaa](https://github.com/guanguans/soar-php/commit/0af6eaa))


<a name="5.1.1"></a>
## [5.1.1] - 2025-03-24
### 📦 Builds
- **dependencies:** Update PHP dependencies in composer.json ([b2b39b9](https://github.com/guanguans/soar-php/commit/b2b39b9))


<a name="5.1.0"></a>
## [5.1.0] - 2025-02-05
### ✨ Features
- **Concerns:** Add Makeable trait for object creation ([bdd8329](https://github.com/guanguans/soar-php/commit/bdd8329))

### 📦 Builds
- **dependencies:** Upgrade phpstan-disallowed-calls and psalm ([425c45a](https://github.com/guanguans/soar-php/commit/425c45a))

### Pull Requests
- Merge pull request [#173](https://github.com/guanguans/soar-php/issues/173) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.3.0


<a name="5.0.3"></a>
## [5.0.3] - 2025-01-16
### 📖 Documents
- **README:** Update badges for CI and versioning ([4af0217](https://github.com/guanguans/soar-php/commit/4af0217))

### 💅 Code Refactorings
- **WithRunable:** Simplify sudo password handling ([4d2a7ca](https://github.com/guanguans/soar-php/commit/4d2a7ca))


<a name="5.0.2"></a>
## [5.0.2] - 2025-01-16
### 🏎 Performance Improvements
- **Concerns:** improve error handling in setSoarBinary ([7ca9c9d](https://github.com/guanguans/soar-php/commit/7ca9c9d))

### 🤖 Continuous Integrations
- **formatting:** Fix formatting issues in .php-cs-fixer.php, examples/soar.options.docblock.php, and src/Support/ComposerScript.php ([cb13eec](https://github.com/guanguans/soar-php/commit/cb13eec))


<a name="5.0.1"></a>
## [5.0.1] - 2025-01-16
### ✨ Features
- **ConcreteMagic:** add serialization and unserialization methods ([281ea2c](https://github.com/guanguans/soar-php/commit/281ea2c))

### 💅 Code Refactorings
- **escape-arg:** Refactor EscapeArg class ([4b13e60](https://github.com/guanguans/soar-php/commit/4b13e60))

### 🏎 Performance Improvements
- **HasSoarBinary:** Improve error handling ([c055edd](https://github.com/guanguans/soar-php/commit/c055edd))
- **commit:** Improve performance by optimizing code ([cd60705](https://github.com/guanguans/soar-php/commit/cd60705))
- **concerns:** optimize arrayScores performance ([6886207](https://github.com/guanguans/soar-php/commit/6886207))

### ✅ Tests
- **commit:** Add test files and update PHPUnit configuration ([2f72539](https://github.com/guanguans/soar-php/commit/2f72539))

### 🤖 Continuous Integrations
- **composer-updater:** Fix PHPStan errors and update dependencies ([d34f96f](https://github.com/guanguans/soar-php/commit/d34f96f))


<a name="5.0.0"></a>
## [5.0.0] - 2025-01-16
### ✨ Features
- **upgrade:** Upgrade PHP version to 7.4 ([c1fdecb](https://github.com/guanguans/soar-php/commit/c1fdecb))

### 📦 Builds
- Update .gitignore, add .php-cs-fixer-dist.php, and modify composer.json, phpstan.neon, phpunit.xml.dist, psalm.xml.dist, rector.php ([3ce0cde](https://github.com/guanguans/soar-php/commit/3ce0cde))

### 🤖 Continuous Integrations
- apply rector ([54e7c79](https://github.com/guanguans/soar-php/commit/54e7c79))
- apply php-cs-fixer ([666e9ee](https://github.com/guanguans/soar-php/commit/666e9ee))
- apply php-cs-fixer ([cb41001](https://github.com/guanguans/soar-php/commit/cb41001))
- **chglog:** update filters and title maps in .chglog/config.yml ([296486f](https://github.com/guanguans/soar-php/commit/296486f))


<a name="4.2.6"></a>
## [4.2.6] - 2025-01-15
### 🤖 Continuous Integrations
- **composer:** Update dependencies ([8f15583](https://github.com/guanguans/soar-php/commit/8f15583))

### Pull Requests
- Merge pull request [#171](https://github.com/guanguans/soar-php/issues/171) from guanguans/dependabot/github_actions/codecov/codecov-action-5


<a name="4.2.5"></a>
## [4.2.5] - 2024-10-11

<a name="4.2.4"></a>
## [4.2.4] - 2024-08-16
### ✅ Tests
- **benchmarks:** Adjust iterations in SoarBench and benchmark settings ([ebdc8b6](https://github.com/guanguans/soar-php/commit/ebdc8b6))


<a name="4.2.3"></a>
## [4.2.3] - 2024-07-16
### 🐞 Bug Fixes
- **HasSudoPassword:** Improve formatting of setSudoPassword method ([c16a715](https://github.com/guanguans/soar-php/commit/c16a715))


<a name="4.2.2"></a>
## [4.2.2] - 2024-07-16
### 📦 Builds
- **composer.json:** update composer-git-hooks and rector versions ([1ea79b5](https://github.com/guanguans/soar-php/commit/1ea79b5))

### 🤖 Continuous Integrations
- **release:** Add StaticClosureRector and update rules ([7d23e06](https://github.com/guanguans/soar-php/commit/7d23e06))

### Pull Requests
- Merge pull request [#170](https://github.com/guanguans/soar-php/issues/170) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.2.0


<a name="4.2.1"></a>
## [4.2.1] - 2024-06-11
### Pull Requests
- Merge pull request [#169](https://github.com/guanguans/soar-php/issues/169) from guanguans/dependabot/github_actions/dependabot/fetch-metadata-2.1.0


<a name="4.2.0"></a>
## [4.2.0] - 2024-04-23
### ✨ Features
- **composer-updater:** add dry-run option ([d27174a](https://github.com/guanguans/soar-php/commit/d27174a))

### 💅 Code Refactorings
- **HasSoarBinary:** rename getDefaultSoarBinary to defaultSoarBinary ([6e66c0f](https://github.com/guanguans/soar-php/commit/6e66c0f))
- **debug:** improve debug info handling ([ab5a04b](https://github.com/guanguans/soar-php/commit/ab5a04b))

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
### 💅 Code Refactorings
- **src:** Improve __debugInfo method ([46c38c7](https://github.com/guanguans/soar-php/commit/46c38c7))

### Pull Requests
- Merge pull request [#160](https://github.com/guanguans/soar-php/issues/160) from guanguans/dependabot/github_actions/codecov/codecov-action-4.0.1
- Merge pull request [#161](https://github.com/guanguans/soar-php/issues/161) from guanguans/dependabot/composer/rector/rector-tw-0.19or-tw-1.0
- Merge pull request [#158](https://github.com/guanguans/soar-php/issues/158) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.6


<a name="4.0.3"></a>
## [4.0.3] - 2024-01-29
### 🐞 Bug Fixes
- **HasSudoPassword:** Update shouldApplySudoPassword condition ([4de799b](https://github.com/guanguans/soar-php/commit/4de799b))

### 💅 Code Refactorings
- **config:** update PHPUnit set and add new rule ([56fea1d](https://github.com/guanguans/soar-php/commit/56fea1d))

### Pull Requests
- Merge pull request [#156](https://github.com/guanguans/soar-php/issues/156) from guanguans/dependabot/github_actions/actions/cache-4
- Merge pull request [#157](https://github.com/guanguans/soar-php/issues/157) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.5


<a name="4.0.2"></a>
## [4.0.2] - 2024-01-16
### ✨ Features
- **composer:** add dump-soar command ([c55c14a](https://github.com/guanguans/soar-php/commit/c55c14a))

### 📖 Documents
- Update README.md and README-zh_CN.md ([7f6209a](https://github.com/guanguans/soar-php/commit/7f6209a))

### 💅 Code Refactorings
- **concerns:** improve magic methods ([361cc04](https://github.com/guanguans/soar-php/commit/361cc04))


<a name="4.0.1"></a>
## [4.0.1] - 2024-01-16
### ✅ Tests
- add snapshot update command ([9bd07a3](https://github.com/guanguans/soar-php/commit/9bd07a3))
- refactor test ([0f38df4](https://github.com/guanguans/soar-php/commit/0f38df4))
- refactor test ([41900fa](https://github.com/guanguans/soar-php/commit/41900fa))
- refactor test ([23a5025](https://github.com/guanguans/soar-php/commit/23a5025))
- refactor test ([8d69a10](https://github.com/guanguans/soar-php/commit/8d69a10))
- replace phpunit -> pest ([fa936ae](https://github.com/guanguans/soar-php/commit/fa936ae))


<a name="4.0.0"></a>
## [4.0.0] - 2024-01-15
### 💅 Code Refactorings
- rename SoarPath -> SoarBinary ([434846c](https://github.com/guanguans/soar-php/commit/434846c))
- **WithRunable:** remove deprecated exec method ([5819542](https://github.com/guanguans/soar-php/commit/5819542))


<a name="3.5.0"></a>
## [3.5.0] - 2024-01-15
### 💅 Code Refactorings
- **monorepo-builder:** update release workers ([b721225](https://github.com/guanguans/soar-php/commit/b721225))

### Pull Requests
- Merge pull request [#155](https://github.com/guanguans/soar-php/issues/155) from guanguans/dependabot/composer/rector/rector-tw-0.18or-tw-0.19
- Merge pull request [#154](https://github.com/guanguans/soar-php/issues/154) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#153](https://github.com/guanguans/soar-php/issues/153) from guanguans/dependabot/github_actions/actions/labeler-5
- Merge pull request [#152](https://github.com/guanguans/soar-php/issues/152) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5


<a name="3.4.4"></a>
## [3.4.4] - 2023-09-15
### 🐞 Bug Fixes
- **HasOptions:** handle callable values in normalizeOption ([2a4215d](https://github.com/guanguans/soar-php/commit/2a4215d))

### 💅 Code Refactorings
- **coding-style:** remove UnSpreadOperatorRector ([e896c23](https://github.com/guanguans/soar-php/commit/e896c23))

### Pull Requests
- Merge pull request [#151](https://github.com/guanguans/soar-php/issues/151) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.4.3"></a>
## [3.4.3] - 2023-08-22
### 🐞 Bug Fixes
- **phpstan:** Ignore errors in Soar.php ([5b308b5](https://github.com/guanguans/soar-php/commit/5b308b5))

### Pull Requests
- Merge pull request [#149](https://github.com/guanguans/soar-php/issues/149) from guanguans/dependabot/composer/rector/rector-tw-0.17or-tw-0.18


<a name="3.4.2"></a>
## [3.4.2] - 2023-07-30
### 🐞 Bug Fixes
- **concerns:** deprecate exec method ([a22f52e](https://github.com/guanguans/soar-php/commit/a22f52e))


<a name="3.4.1"></a>
## [3.4.1] - 2023-07-24
### 🐞 Bug Fixes
- **Concerns:** Fix InvalidOptionException in ConcreteMagic trait ([8377e5c](https://github.com/guanguans/soar-php/commit/8377e5c))

### 💅 Code Refactorings
- **WithRunable:** simplify process tapper logic ([df9f828](https://github.com/guanguans/soar-php/commit/df9f828))


<a name="3.4.0"></a>
## [3.4.0] - 2023-07-23
### ✨ Features
- **bin:** Add support for Linux ARM64 architecture ([4b2c1aa](https://github.com/guanguans/soar-php/commit/4b2c1aa))
- **monorepo-builder:** Add monorepo-builder configuration ([6ecedc0](https://github.com/guanguans/soar-php/commit/6ecedc0))

### 🐞 Bug Fixes
- **concerns:** Update Soar path for Linux ARM64 ([51e136f](https://github.com/guanguans/soar-php/commit/51e136f))
- **path:** update Soar path for linux-amd64 ([f8ee9f4](https://github.com/guanguans/soar-php/commit/f8ee9f4))


<a name="v3.3.4"></a>
## [v3.3.4] - 2023-07-16
### 💅 Code Refactorings
- **HasOptions:** update onlyOptions method ([a7ce8a3](https://github.com/guanguans/soar-php/commit/a7ce8a3))


<a name="v3.3.3"></a>
## [v3.3.3] - 2023-07-16
### ✨ Features
- **lint:** Add json-lint and yaml-lint checks ([94dbeed](https://github.com/guanguans/soar-php/commit/94dbeed))

### 🐞 Bug Fixes
- **HasSoarPath:** Add getEscapedSoarPath method ([ec38dfe](https://github.com/guanguans/soar-php/commit/ec38dfe))

### 💅 Code Refactorings
- **HasOptions:** change access modifiers of methods ([22bf483](https://github.com/guanguans/soar-php/commit/22bf483))
- **HasOptions:** rename method getSerializedEscapedNormalizedOptions to getHydratedEscapedNormalizedOptions ([b2b10b7](https://github.com/guanguans/soar-php/commit/b2b10b7))


<a name="v3.3.2"></a>
## [v3.3.2] - 2023-07-15
### 🐞 Bug Fixes
- **workflows:** update php-cs-fixer workflow ([e6fd9f6](https://github.com/guanguans/soar-php/commit/e6fd9f6))

### 💅 Code Refactorings
- **HasOptions:** update getSerializedEscapedNormalizedOptions method ([231149d](https://github.com/guanguans/soar-php/commit/231149d))
- **rector:** remove unused imports and update rules ([37513d6](https://github.com/guanguans/soar-php/commit/37513d6))


<a name="v3.3.1"></a>
## [v3.3.1] - 2023-07-14
### ✨ Features
- **tests:** Add new test file for SudoPassword ([7bab1d4](https://github.com/guanguans/soar-php/commit/7bab1d4))

### 📖 Documents
- **README.md:** add section for fatal error and its fix ([55def24](https://github.com/guanguans/soar-php/commit/55def24))

### 💅 Code Refactorings
- **HasSudoPassword:** improve escaping of sudo password ([89fff21](https://github.com/guanguans/soar-php/commit/89fff21))


<a name="v3.3.0"></a>
## [v3.3.0] - 2023-07-14
### ✨ Features
- **HasSudoPassword:** Add new trait ([6e3434c](https://github.com/guanguans/soar-php/commit/6e3434c))

### 💅 Code Refactorings
- **concerns:** update getEscapeSudoPassword method ([9ba70bc](https://github.com/guanguans/soar-php/commit/9ba70bc))
- **concerns:** update shouldApplySudoPassword logic ([d205948](https://github.com/guanguans/soar-php/commit/d205948))
- **sudo:** move sudo password related methods to trait ([c7daecd](https://github.com/guanguans/soar-php/commit/c7daecd))

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
### 📖 Documents
- update .all-contributorsrc [skip ci] ([d382662](https://github.com/guanguans/soar-php/commit/d382662))
- update README-EN.md [skip ci] ([d6f4a1b](https://github.com/guanguans/soar-php/commit/d6f4a1b))
- update README.md [skip ci] ([721c5f9](https://github.com/guanguans/soar-php/commit/721c5f9))
- update .all-contributorsrc [skip ci] ([63a91ae](https://github.com/guanguans/soar-php/commit/63a91ae))
- update README-EN.md [skip ci] ([ec34f47](https://github.com/guanguans/soar-php/commit/ec34f47))
- update README.md [skip ci] ([965c07b](https://github.com/guanguans/soar-php/commit/965c07b))

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
### 📖 Documents
- Update README.md ([1b8a238](https://github.com/guanguans/soar-php/commit/1b8a238))
- Update README.md ([808d67a](https://github.com/guanguans/soar-php/commit/808d67a))

### 🏎 Performance Improvements
- Remove config file init ([73bc7a9](https://github.com/guanguans/soar-php/commit/73bc7a9))
- Delete `Services/SoarService.php` ([a3290e1](https://github.com/guanguans/soar-php/commit/a3290e1))

### 📦 Builds
- Update composer.json ([c54227e](https://github.com/guanguans/soar-php/commit/c54227e))


<a name="v2.1.0"></a>
## [v2.1.0] - 2021-04-25
### 📖 Documents
- Update README.md ([2429522](https://github.com/guanguans/soar-php/commit/2429522))

### ✅ Tests
- Fix tests ([f237faa](https://github.com/guanguans/soar-php/commit/f237faa))

### 🤖 Continuous Integrations
- Add php-cs-fixer、psalm、cghooks ([1ba0932](https://github.com/guanguans/soar-php/commit/1ba0932))


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
### 📖 Documents
- add huangdijia as a contributor ([#15](https://github.com/guanguans/soar-php/issues/15)) ([2f67ceb](https://github.com/guanguans/soar-php/commit/2f67ceb))
- update .all-contributorsrc ([d9ac7ca](https://github.com/guanguans/soar-php/commit/d9ac7ca))
- update README-EN.md ([f9050b3](https://github.com/guanguans/soar-php/commit/f9050b3))
- update README.md ([6ee6429](https://github.com/guanguans/soar-php/commit/6ee6429))


<a name="v1.1.5"></a>
## [v1.1.5] - 2019-08-29

<a name="v1.1.4"></a>
## [v1.1.4] - 2019-08-29

<a name="v1.1.3"></a>
## [v1.1.3] - 2019-08-24
### 📖 Documents
- add leslieeilsel as a contributor ([#11](https://github.com/guanguans/soar-php/issues/11)) ([7ff8f98](https://github.com/guanguans/soar-php/commit/7ff8f98))
- update .all-contributorsrc ([cd44ca8](https://github.com/guanguans/soar-php/commit/cd44ca8))
- update README.md ([03cd69c](https://github.com/guanguans/soar-php/commit/03cd69c))
- add kamly as a contributor ([#10](https://github.com/guanguans/soar-php/issues/10)) ([2950051](https://github.com/guanguans/soar-php/commit/2950051))
- create .all-contributorsrc ([e22ec09](https://github.com/guanguans/soar-php/commit/e22ec09))
- update README.md ([ce73ff7](https://github.com/guanguans/soar-php/commit/ce73ff7))


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

[Unreleased]: https://github.com/guanguans/soar-php/compare/7.0.3...HEAD
[7.0.3]: https://github.com/guanguans/soar-php/compare/7.0.2...7.0.3
[7.0.2]: https://github.com/guanguans/soar-php/compare/7.0.1...7.0.2
[7.0.1]: https://github.com/guanguans/soar-php/compare/7.0.0...7.0.1
[7.0.0]: https://github.com/guanguans/soar-php/compare/6.3.0...7.0.0
[6.3.0]: https://github.com/guanguans/soar-php/compare/6.2.0...6.3.0
[6.2.0]: https://github.com/guanguans/soar-php/compare/6.1.0...6.2.0
[6.1.0]: https://github.com/guanguans/soar-php/compare/6.0.4...6.1.0
[6.0.4]: https://github.com/guanguans/soar-php/compare/6.0.3...6.0.4
[6.0.3]: https://github.com/guanguans/soar-php/compare/6.0.2...6.0.3
[6.0.2]: https://github.com/guanguans/soar-php/compare/6.0.1...6.0.2
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
