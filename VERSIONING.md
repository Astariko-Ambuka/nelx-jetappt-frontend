# Versioning

This project uses **Semantic Versioning 2.0.0** ([semver.org](https://semver.org/))

## Version Format

Versions are formatted as **MAJOR.MINOR.PATCH** (e.g., `1.0.0`)

- **MAJOR**: Incompatible API changes
- **MINOR**: New functionality in a backwards-compatible manner
- **PATCH**: Backwards-compatible bug fixes

## Release Process

1. Update `version.txt` with the new version number
2. Update `CHANGELOG.md` with changes for this release
3. Commit changes: `git commit -m "Release v<VERSION>"`
4. Create a git tag: `git tag v<VERSION>`
5. Push tag: `git push origin v<VERSION>`
6. Create a GitHub Release from the tag with release notes from `CHANGELOG.md`

You can create releases via:
- GitHub CLI: `gh release create v<VERSION> --notes-file CHANGELOG-ENTRY.md`
- GitHub Web UI: Go to [Releases](https://github.com/Astariko-Ambuka/nelx-jetappt-frontend/releases) → "Create a new release"

## Current Version

See `version.txt` for the current version.

## Examples

- `1.0.0` → Initial release
- `1.0.1` → Bug fix
- `1.1.0` → New feature
- `2.0.0` → Breaking changes
