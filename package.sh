#!/usr/bin/env bash
# ==============================================================================
# Kalalayaa WordPress Production Packager
# Bundles the FSE Theme and Companion Plugin into installable ZIP packages.
# ==============================================================================

set -euo pipefail

DIST_DIR="$(pwd)/dist"
mkdir -p "$DIST_DIR"

echo "📦 Packaging Kalalayaa FSE Theme..."
cd wp-content/themes
zip -r -q "$DIST_DIR/kalalayaa-theme.zip" kalalayaa -x "*/.git*" "*/.DS_Store"
cd ../..

echo "📦 Packaging Kalalayaa Admissions Engine Plugin..."
cd wp-content/plugins
zip -r -q "$DIST_DIR/kalalayaa-admissions-engine.zip" kalalayaa-admissions-engine -x "*/.git*" "*/.DS_Store"
cd ../..

echo "✨ Packages built successfully in $DIST_DIR:"
ls -lh "$DIST_DIR"
