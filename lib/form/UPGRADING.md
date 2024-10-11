# core_form (subsystem) Upgrade notes

## 4.5

### Added

- The `duration` form field type has been modified to validate that the supplied value is a positive value.
  Previously it could be any numeric value, but every usage of this field in agpu was expecting a positive value. When a negative value was provided and accepted, subtle bugs could occur.
  Where a negative duration _is_ allowed, the `allownegative` attribute can be set to `true`.

  For more information see [MDL-82687](https://tracker.agpu.org/browse/MDL-82687)
