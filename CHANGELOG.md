# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 3.4.0 - TBD

### Added

- Nothing.

### Changed

- Nothing.

### Deprecated

- Nothing.

### Removed

- Nothing.

### Fixed

- Nothing.

## 3.3.0 - 2023-04-30


-----

### Release Notes for [3.3.0](https://github.com/nucleos/setlistfm/milestone/3)

Feature release (minor)

### 3.3.0

- Total issues resolved: **0**
- Total pull requests resolved: **6**
- Total contributors: **2**

#### Enhancement

 - [401: Update build tools](https://github.com/nucleos/setlistfm/pull/401) thanks to @core23
 - [400: Drop prophecy](https://github.com/nucleos/setlistfm/pull/400) thanks to @core23
 - [332: Use shared pipelines](https://github.com/nucleos/setlistfm/pull/332) thanks to @core23
 - [322: Remove composer-bin plugin](https://github.com/nucleos/setlistfm/pull/322) thanks to @core23

#### dependency

 - [399: Update dependency psr/http-message to ^1.0 || ^2.0](https://github.com/nucleos/setlistfm/pull/399) thanks to @renovate[bot]
 - [397: Drop support for PHP 8.0](https://github.com/nucleos/setlistfm/pull/397) thanks to @core23

## 3.2.0 - 2021-12-06



-----

### Release Notes for [3.2.0](https://github.com/nucleos/setlistfm/milestone/1)



### 3.2.0

- Total issues resolved: **0**
- Total pull requests resolved: **3**
- Total contributors: **2**

#### Enhancement

 - [319: Update tools and use make to run them](https://github.com/nucleos/setlistfm/pull/319) thanks to @core23

#### dependency

 - [315: Update psr/log requirement from ^1.0 to ^1.0 || ^2.0 || ^3.0](https://github.com/nucleos/setlistfm/pull/315) thanks to @dependabot[bot]
 - [313: Drop PHP 7 support](https://github.com/nucleos/setlistfm/pull/313) thanks to @core23

## 3.1.0

### Changes

### 🐛 Bug Fixes

- Check for null values when parsing [@core23] ([#123])

### 📦 Dependencies

- Add support for PHP 8 [@core23] ([#133])
- Drop support for PHP 7.2 [@core23] ([#64])

## 3.0.0

### Changes

- Renamed namespace `Core23\SetlistFm` to `Nucleos\SetlistFm` after move to [@nucleos]

  Run

  ```
  $ composer remove core23/setlistfm-api
  ```

  and

  ```
  $ composer require nucleos/setlistfm
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Core23\\SetlistFm/Nucleos\\SetlistFm/g' {} \;
  ```

  to replace occurrences of `Core23\SetlistFm` with `Nucleos\SetlistFm`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

- Add missing strict file header [@core23] ([#31])
- Replace HTTPlug with PSR http client [@core23] ([#26])

### 🚀 Features

- Use builder to pass search parameter
- Add psalm [@core23] ([#54])

## 2.0.0

### Changes

- Add missing strict file header [@core23] ([#31])

### ❌ BC Breaks

- Replace HTTPlug with PSR http client [@core23] ([#26])
- Use builder to pass search parameter

[#54]: https://github.com/nucleos/setlistfm/pull/54
[#31]: https://github.com/nucleos/setlistfm/pull/31
[#26]: https://github.com/nucleos/setlistfm/pull/26
[@nucleos]: https://github.com/nucleos
[@core23]: https://github.com/core23
[#133]: https://github.com/nucleos/setlistfm/pull/133
[#123]: https://github.com/nucleos/setlistfm/pull/123
[#64]: https://github.com/nucleos/setlistfm/pull/64
