module.exports = {
  devServer: {
    host: "localhost"
  },
  configureWebpack: {
    devtool: "source-map"
  },
  transpileDependencies: ["vuetify"]
};
