import { extend, values } from "lodash";


export default function ({
                             emptyItem = {
                                 id: null,
                                 product_name: null,
                                 quantity_in_stock: null,
                                 price_per_item: null,
                                 created_at: null,
                             },
                             responseDelay = 1000,
                             fetchResponseDelay = 500,
                         }) {

    let idIncrement = 1;

    return {
        items: {},
        fetch(){
            let data = values(this.items);

            console.log('server', 'fetch', data);
            return delayedResponse(data, fetchResponseDelay);

        },
        create(item){
            item = json(item);

            item.id             = idIncrement++;
            let created         = makeItem(item);
            this.items[item.id] = created;

            console.log('server', 'create', created);
            return delayedResponse(created, responseDelay);

        },
        update(item){
            item                = json(item);
            let current         = this.items[item.id];
            item.revision       = current.revision;
            let updated         = makeItem(item);
            this.items[item.id] = updated;

            console.log('server', 'update', updated);
            return delayedResponse(updated, responseDelay);

        },
        delete(item){
            item = json(item);

            let current = this.items[item.id];
            let deleted = makeItem(current);

            delete this.items[item.id];

            console.log('server', 'delete', deleted);
            return delayedResponse(deleted, responseDelay);
        }
    };

    function makeItem(item) {
        return itemFactory(item, emptyItem);
    }

}

function itemFactory(item, emptyItem) {
    let result = extend({revision: 0}, emptyItem, item);

    result.revision++;

    return result;
}

function json(data) {
    return JSON.parse(JSON.stringify(data));
}

function delayedResponse(value, delay) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            resolve(value)
        }, delay);
    });
}
