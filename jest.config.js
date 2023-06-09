export default {
  preset: 'ts-jest',
  testMatch: [
    '**/__tests__/**/*.test.[jt]s?(x)',
    '**/?(*.)+(spec|test).[jt]s?(x)',
  ],
  transform: {
    "^.+\\.vue$": "@vue/vue3-jest",
    '^.+\\.jsx?$': 'babel-jest',
    '^.+\\.ts$': 'ts-jest',
  },
  moduleNameMapper: {
    "axios": "axios/dist/node/axios.cjs"
  },
  moduleFileExtensions: ['vue', 'js', 'json', 'jsx', 'ts', 'tsx', 'node'],
  testEnvironment: 'jest-environment-jsdom',
  testEnvironmentOptions: {
    "resources": "usable",
    "url": "http://localhost"
  },
};