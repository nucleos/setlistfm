# 3.1.0

## Changes

## 🐛 Bug Fixes

- Check for null values when parsing @core23 (#123)

## 📦 Dependencies

- Add support for PHP 8 @core23 (#133)
- Drop support for PHP 7.2 @core23 (#64)

# 3.0.0

## Changes

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

## 🚀 Features

- Use builder to pass search parameter
- Add psalm [@core23] ([#54])

# 2.0.0

## Changes

- Add missing strict file header [@core23] ([#31])

## ❌ BC Breaks

- Replace HTTPlug with PSR http client [@core23] ([#26])
- Use builder to pass search parameter

[#54]: https://github.com/nucleos/setlistfm/pull/54
[#31]: https://github.com/nucleos/setlistfm/pull/31
[#26]: https://github.com/nucleos/setlistfm/pull/26
[@nucleos]: https://github.com/nucleos
[@core23]: https://github.com/core23
