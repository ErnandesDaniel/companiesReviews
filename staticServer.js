
const express = require('express');
const path = require('path');
const history = require('connect-history-api-fallback');
const app = express();
const staticFileMiddleware = express.static(path.join(__dirname+'/app/dist'))

app.use(staticFileMiddleware);
app.use(history());
app.use(staticFileMiddleware);

app.get('/', function (req, res) {
  res.render(path.join('./public/index.html'));
})

const port=448;

app.listen(port, function () {
  console.log( 'Приложение запущено на порту '+port+'!');
})




