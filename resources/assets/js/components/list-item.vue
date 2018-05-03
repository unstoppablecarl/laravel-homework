<template>
    <div class="row list-item">
        <div class="col-sm-1">

            <template v-if="mode === 'edit'">
                <label>ID</label>
            </template>

            <div class="form-control-static">
                {{model.id}}
            </div>
        </div>

        <div class="col-sm-2">
            <template v-if="mode === 'edit'">

                <label>Product Name</label>
                <input type="text" class="form-control" v-model="model.product_name">

            </template>
            <template v-else>
                <div class="form-control-static">
                    {{model.product_name}}
                </div>
            </template>
        </div>

        <div class="col-sm-2">
            <template v-if="mode === 'edit'">

                <label>Product Quantity</label>
                <input type="text" class="form-control" v-model="model.quantity_in_stock">

            </template>

            <template v-else>

                <div class="form-control-static">
                    {{model.quantity_in_stock}}
                </div>

            </template>
        </div>

        <div class="col-sm-2">
            <template v-if="mode === 'edit'">

                <label>Price Per Item</label>
                <input type="text" class="form-control" v-model="model.price_per_item">

            </template>

            <template v-else>

                <div class="form-control-static">
                    {{model.price_per_item}}
                </div>

            </template>
        </div>

        <div class="col-sm-1">
            <div class="form-control-static">
                {{model.created_at}}
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-control-static">
                {{model.price_per_item * model.quantity_in_stock}}
            </div>
        </div>

        <div class="col-sm-2">

            <template v-if="mode === 'save'">
                <div class="form-control-static">
                    <strong>Saving</strong>
                </div>
            </template>

            <template v-if="mode === 'delete'">
                <div class="form-control-static">
                    <strong>Deleting</strong>
                </div>
            </template>

            <template v-if="mode === 'edit'">
                <label>Editing</label>
                <br>
                <button class="btn btn-success" :disabled="!itemValid" @click="save()">Save</button>
                <button class="btn btn-primary" @click="cancelEdit()">Cancel</button>
            </template>

            <template v-if="mode === 'view'">
                <button class="btn btn-primary" @click="edit()">Edit</button>
                <button class="btn btn-danger" @click="remove()">Delete</button>
            </template>

        </div>

    </div>
</template>

<script>

    import Model from '../lib/model';

    let {parse} = Model({
        defaults: {
            id: null,
            product_name: null,
            quantity_in_stock: null,
            price_per_item: null,
            created_at: null,
        }
    });

    export default {
        name: 'list-item',
        props: {
            item: {
                type: Object,
            },
        },
        data() {
            return {
                mode: 'view',
                model: parse(this.item),
            };
        },
        methods: {
            resetModel(){
                this.model = parse(this.item);
            },
            edit(){
                this.resetModel();
                this.mode = 'edit';
            },
            cancelEdit(){
                this.resetModel();
                this.mode = 'view';
            },

            save(){
                this.mode = 'save';
                this.$store
                    .dispatch('update', this.model)
                    .then(() => {
                        this.mode = 'view';
                    });
            },
            remove(){
                this.mode = 'delete';

                this.$store
                    .dispatch('delete', this.model);
            },
        },
        watch: {
            item(item){
                this.model = parse(item);
            }
        },
        computed: {
            itemValid(){
                return this.model.product_name && this.model.quantity_in_stock && this.model.price_per_item;
            }
        }
    }
</script>


<style lang="scss" scoped>

</style>
