/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')
const { fileURLToPath } = require('url');
const path = require('path');

module.exports = {
  root: true,
  'extends': [
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    '@vue/eslint-config-prettier/skip-formatting'
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    parser: '@typescript-eslint/parser', // Specify the TypeScript parser
    sourceType: 'module',
  },
  plugins: ['@typescript-eslint'], // Specify the TypeScript plugin
  settings: {
    'import/resolver': {
      alias: {
        map: [
          ['@', path.resolve(__dirname, 'src')]
        ],
        extensions: ['.js', '.jsx', '.ts', '.tsx', '.vue'],
      },
    },
  },
}
