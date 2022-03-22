window._ = require('lodash');
 
require('bootstrap');
require('datatables.net-bs4');
require('datatables.net-buttons-bs4');

try {
    // window.Popper = require('popper.js').default;
    global.$ = global.jQuery = require('jquery');

    require('bootstrap');

} catch (e) {
    console.log(e);
}
 

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
 