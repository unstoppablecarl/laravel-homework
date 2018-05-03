import * as axios from 'axios';
import {each} from 'lodash';


const BASE_URL = '/api/products';

export default {
    fetch() {

        var data   = {};
        var config = {};
        var url    = BASE_URL;

        return axios.get(url, data, config)
            .catch(function (err) {
                console.log('err', err);
            })
            .then(function (res) {
                return res.data;
            });
    },
    create(item) {

        var url = BASE_URL;

        return axios.post(url, item)

            .catch(function (err) {
                console.log('err', err);
            })
            .then(function (res) {
                return res.data;
            });

    },
    update(item) {

        var url = BASE_URL + '/' + item.id;

        return axios.put(url, item)
            .catch(function (err) {
                console.log('err', err);
            })
            .then(function (res) {
                return res.data;
            });
    },
    delete(item) {

        var data   = {};
        var config = {};
        var url    = BASE_URL + '/' + item.id;

        return axios.delete(url, data, config)
            .catch(function (err) {
                console.log('err', err);
            })
            .then(function (res) {
                return res.data;
            });
    },
};

