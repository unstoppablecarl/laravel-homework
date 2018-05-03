<template>
    <div class="list-item-new-container">

        <div class="row list-header">
            <div class="col-sm-1">

            </div>
            <div class="col-sm-2">
                Product Name
            </div>
            <div class="col-sm-2">
                Quantity In Stock
            </div>
            <div class="col-sm-2">
                Price Per Item
            </div>
            <div class="col-sm-2">
                Actions
            </div>
        </div>

        <div class="row list-item-new">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-2">
                <template v-if="mode === 'edit'">

                    <input class="form-control" v-model="model.product_name">

                </template>

                <template v-if="mode === 'save'">
                    <div class="form-control-static">
                        {{model.product_name}}
                    </div>
                </template>

            </div>

            <div class="col-sm-2">
                <template v-if="mode === 'edit'">

                    <input class="form-control" v-model="model.quantity_in_stock">

                </template>
                <template v-else>

                    <div class="form-control-static">
                        {{model.quantity_in_stock}}
                    </div>

                </template>
            </div>
            <div class="col-sm-1">
                <template v-if="mode === 'edit'">

                    <input class="form-control" v-model="model.price_per_item">

                </template>
                <template v-else>

                    <div class="form-control-static">
                        {{model.price_per_item}}
                    </div>

                </template>
            </div>
            <div class="col-sm-1">
                New
            </div>

            <div class="col-sm-2">

                <template v-if="mode === 'save'">
                    <div class="form-control-static">
                        <strong>Saving</strong>
                    </div>
                </template>

                <template v-if="mode === 'edit'">
                    <button class="btn btn-success" :disabled="!itemValid" @click="add()">Add</button>

                    <template v-if="itemValid">
                        <button class="btn btn-default" @click="reset()">Cancel</button>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import Model from '../lib/model';

    import { extend } from "lodash";



    let { defaults } = Model({
        defaults: {
            id: null,
            product_name: null,
            quantity_in_stock: null,
            price_per_item: null,
            created_at: null,
        }
    });

    export default {
        name: 'list-item-new',

        data() {
            return this.data();
        },
        methods: {
            data() {
                return {
                    mode: 'edit',
                    model: defaults(),
                };
            },
            reset(){
                extend(this.$data, this.data());
            },
            add() {
                this.mode = 'save';

                this.$store
                    .dispatch('create', this.model)
                    .then(() => {
                        this.reset();
                    });
            },
        },
        computed: {
            itemValid(){
                return this.model.product_name && this.model.quantity_in_stock && this.model.price_per_item;
            }
        }
    }
</script>
