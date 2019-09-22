module.exports = {
    testRegex: 'resources/js/tests/.*.test.js$',
    moduleNameMapper: {
      "^@components(.*)$": "<rootDir>/resources/js/components$1",
      "^@helpers(.*)$": "<rootDir>/resources/js/helpers$1",
      "^@classes(.*)$": "<rootDir>/resources/js/classes$1",
      "^@mixins(.*)$": "<rootDir>/resources/js/mixins$1",
    },
    moduleFileExtensions: [
      'js',
      'json',
      'vue'
    ],
    'transform': {
      '^.+\\.js$': '<rootDir>/node_modules/babel-jest',
      '.*\\.(vue)$': '<rootDir>/node_modules/vue-jest'
    },
  }

