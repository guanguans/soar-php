<!--- BEGIN HEADER -->
# Changelog

All notable changes to this project will be documented in this file.
<!--- END HEADER -->

<a name="unreleased"></a>
## [Unreleased]


<a name="4.2.4"></a>
## [4.2.4] - 2024-08-16
### Test
- **benchmarks:** Adjust iterations in SoarBench and benchmark settings


<a name="4.2.3"></a>
## [4.2.3] - 2024-07-16
### Fix
- **HasSudoPassword:** Improve formatting of setSudoPassword method


<a name="4.2.2"></a>
## [4.2.2] - 2024-07-16
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
### Feat
- **composer-updater:** add dry-run option

### Refactor
- **HasSoarBinary:** rename getDefaultSoarBinary to defaultSoarBinary
- **debug:** improve debug info handling

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
### Refactor
- **src:** Improve __debugInfo method

### Pull Requests
- Merge pull request [#160](https://github.com/guanguans/soar-php/issues/160) from guanguans/dependabot/github_actions/codecov/codecov-action-4.0.1
- Merge pull request [#161](https://github.com/guanguans/soar-php/issues/161) from guanguans/dependabot/composer/rector/rector-tw-0.19or-tw-1.0
- Merge pull request [#158](https://github.com/guanguans/soar-php/issues/158) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.6


<a name="4.0.3"></a>
## [4.0.3] - 2024-01-29
### Fix
- **HasSudoPassword:** Update shouldApplySudoPassword condition

### Refactor
- **config:** update PHPUnit set and add new rule

### Pull Requests
- Merge pull request [#156](https://github.com/guanguans/soar-php/issues/156) from guanguans/dependabot/github_actions/actions/cache-4
- Merge pull request [#157](https://github.com/guanguans/soar-php/issues/157) from guanguans/dependabot/github_actions/codecov/codecov-action-3.1.5


<a name="4.0.2"></a>
## [4.0.2] - 2024-01-16
### Docs
- Update README.md and README-zh_CN.md

### Feat
- **composer:** add dump-soar command

### Refactor
- **concerns:** improve magic methods


<a name="4.0.1"></a>
## [4.0.1] - 2024-01-16
### Test
- add snapshot update command
- refactor test
- refactor test
- refactor test
- refactor test
- replace phpunit -> pest


<a name="4.0.0"></a>
## [4.0.0] - 2024-01-15
### Refactor
- rename SoarPath -> SoarBinary
- **WithRunable:** remove deprecated exec method


<a name="3.5.0"></a>
## [3.5.0] - 2024-01-15
### Refactor
- **monorepo-builder:** update release workers

### Pull Requests
- Merge pull request [#155](https://github.com/guanguans/soar-php/issues/155) from guanguans/dependabot/composer/rector/rector-tw-0.18or-tw-0.19
- Merge pull request [#154](https://github.com/guanguans/soar-php/issues/154) from guanguans/dependabot/github_actions/actions/stale-9
- Merge pull request [#153](https://github.com/guanguans/soar-php/issues/153) from guanguans/dependabot/github_actions/actions/labeler-5
- Merge pull request [#152](https://github.com/guanguans/soar-php/issues/152) from guanguans/dependabot/github_actions/stefanzweifel/git-auto-commit-action-5


<a name="3.4.4"></a>
## [3.4.4] - 2023-09-15
### Fix
- **HasOptions:** handle callable values in normalizeOption

### Refactor
- **coding-style:** remove UnSpreadOperatorRector

### Pull Requests
- Merge pull request [#151](https://github.com/guanguans/soar-php/issues/151) from guanguans/dependabot/github_actions/actions/checkout-4


<a name="3.4.3"></a>
## [3.4.3] - 2023-08-22
### Fix
- **phpstan:** Ignore errors in Soar.php

### Pull Requests
- Merge pull request [#149](https://github.com/guanguans/soar-php/issues/149) from guanguans/dependabot/composer/rector/rector-tw-0.17or-tw-0.18


<a name="3.4.2"></a>
## [3.4.2] - 2023-07-30
### Fix
- **concerns:** deprecate exec method


<a name="3.4.1"></a>
## [3.4.1] - 2023-07-24
### Fix
- **Concerns:** Fix InvalidOptionException in ConcreteMagic trait

### Refactor
- **WithRunable:** simplify process tapper logic


<a name="3.4.0"></a>
## [3.4.0] - 2023-07-23
### Feat
- **bin:** Add support for Linux ARM64 architecture
- **monorepo-builder:** Add monorepo-builder configuration

### Fix
- **concerns:** Update Soar path for Linux ARM64
- **path:** update Soar path for linux-amd64


<a name="v3.3.4"></a>
## [v3.3.4] - 2023-07-16
### Refactor
- **HasOptions:** update onlyOptions method


<a name="v3.3.3"></a>
## [v3.3.3] - 2023-07-16
### Feat
- **lint:** Add json-lint and yaml-lint checks

### Fix
- **HasSoarPath:** Add getEscapedSoarPath method

### Refactor
- **HasOptions:** change access modifiers of methods
- **HasOptions:** rename method getSerializedEscapedNormalizedOptions to getHydratedEscapedNormalizedOptions


<a name="v3.3.2"></a>
## [v3.3.2] - 2023-07-15
### Fix
- **workflows:** update php-cs-fixer workflow

### Refactor
- **HasOptions:** update getSerializedEscapedNormalizedOptions method
- **rector:** remove unused imports and update rules


<a name="v3.3.1"></a>
## [v3.3.1] - 2023-07-14
### Docs
- **README.md:** add section for fatal error and its fix

### Feat
- **tests:** Add new test file for SudoPassword

### Refactor
- **HasSudoPassword:** improve escaping of sudo password


<a name="v3.3.0"></a>
## [v3.3.0] - 2023-07-14
### Feat
- **HasSudoPassword:** Add new trait

### Refactor
- **concerns:** update getEscapeSudoPassword method
- **concerns:** update shouldApplySudoPassword logic
- **sudo:** move sudo password related methods to trait

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
### Docs
- Update README.md
- Update README.md

### Perf
- Remove config file init
- Delete `Services/SoarService.php`


<a name="v2.1.0"></a>
## [v2.1.0] - 2021-04-25
### CI
- Add php-cs-fixer、psalm、cghooks

### Docs
- Update README.md

### Test
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

[Unreleased]: https://github.com/guanguans/soar-php/compare/4.2.4...HEAD
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
