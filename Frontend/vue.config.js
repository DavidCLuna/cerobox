const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  productionSourceMap: false,
  configureWebpack: {
    performance: {
      hints: 'warning',
      maxAssetSize: 244 * 1024,
      maxEntrypointSize: 244 * 1024
    }
  },
  transpileDependencies: [
    'vuetify'
  ],

  pluginOptions: {
    vuetify: {
			// https://github.com/vuetifyjs/vuetify-loader/tree/next/packages/vuetify-loader
		}
  }
})
