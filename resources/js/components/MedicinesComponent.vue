<template>
    <div>
        <h2>My Medicines</h2>
        <ul class="list-group">
            <li v-for="med in medicineList" class="list-group-item" @click="getMedicine(med.id)">{{ med.name }}</li>
        </ul>
        <div class="text-center">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-medicine">Add</button>
        </div>

        <div id="modal-medicine" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Medicine</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" @submit.prevent="save" novalidate>
                        <input type="hidden" id="id" v-model="medicine.id">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Medicine name</label>
                                <input type="text" class="form-control" id="name" v-model="medicine.name">
                            </div>
                            <div class="form-group">
                                <label for="format">Format</label>
                                <select class="form-control" id="format" v-model="medicine.format">
                                    <option v-for="item in formatsList" :key="item.value" :value="item.value">{{ item.label }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exp_date">Expire date</label>
                                <input type="text" class="form-control" id="exp_date" v-model="medicine.exp_date">
                            </div>
                            <div class="form-group">
                                <label for="available_qty">Available quantity</label>
                                <input type="text" class="form-control" id="available_qty" v-model="medicine.available_qty">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "MedicinesComponent",
        data: function () {
            return {
                medicineList: null,
                medicine: {
                    id: null,
                    name: null,
                    format: null,
                    exp_date: null,
                    available_qty: null
                },
                formatsList: [
                    {value: 'CAPSULE', label: 'Capsule'},
                    {value: 'CREAM', label: 'Cream or lotion'},
                    {value: 'DROPS', label: 'Drops'},
                    {value: 'INHALERS', label: 'Inhaler'},
                    {value: 'INJECTION', label: 'Injection'},
                    {value: 'MIXTURE', label: 'Mixture, solution or syrup'},
                    {value: 'PATCH', label: 'Patch'},
                    {value: 'SUPPOSITORIE', label: 'Supositorie'},
                    {value: 'TABLET', label: 'Tablet'}
                ]
            }
        },
        mounted: function () {
            this.fetchMedicines();
        },
        methods: {
            fetchMedicines: function () {
                console.log('Fetching user medicines...');

                // API request to load the current user medicines.
                //this.loading = true;
                window.axios.get('api/medicine').then((response) => {
                    console.log(response.data);
                    this.medicineList = response.data.data.medicines;
                }).catch((error) => {
                    // this.errored = true;
                    console.error(error);
                }).finally(() => {
                    // this.loading = false
                });
            },
            save: function () {
                console.log('Saving medicine...');

                // Parameters that will be sent with the request.
                /*let params = {
                    medicine: Object
                }.assign({}, this.medicine);*/

                // API request to save/update the user settings.
                // this.loading = true;
                // this.success = false;
                window.axios.post('api/medicine', this.medicine).then((response) => {
                    if (response.data.success) {
                        this.medicine.id = null;
                        this.medicine.name = null;
                        this.medicine.format = null;
                        this.medicine.exp_date = null;
                        this.medicine.available_qty = null;
                        $('#modal-medicine').modal('hide');
                        this.fetchMedicines();

                        // this.$toast.success(response.data.message);
                    } else {
                        // this.errored = true;
                    }
                }).catch((error) => {
                    // this.errored = true;
                    console.error(error);
                }).finally(() => {
                    // this.loading = false
                });
            },
            getMedicine: function (id) {
                // API request to save/update the user settings.
                // this.loading = true;
                // this.success = false;
                window.axios.get('api/medicine/' + id).then((response) => {
                    if (response.data.success) {
                        this.medicine.id = response.data.data.id;
                        this.medicine.name = response.data.data.name;
                        this.medicine.format = response.data.data.format;
                        this.medicine.exp_date = response.data.data.exp_date;
                        this.medicine.available_qty = response.data.data.available_qty;
                        $('#modal-medicine').modal('show');

                        // this.$toast.success(response.data.message);
                    } else {
                        // this.errored = true;
                    }
                }).catch((error) => {
                    // this.errored = true;
                    console.error(error);
                }).finally(() => {
                    // this.loading = false
                });
            }
        }
    }
</script>

<style scoped>

</style>
