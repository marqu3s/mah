<template>
    <div>
        <h2>My Medicines</h2>
        <ul class="list-group">
            <li v-for="med in medicineList" class="list-group-item medicine" @click="getMedicine(med.id)">
                <div class="float-left">
                    {{ med.name }}<br>
                    <span class="badge badge-secondary">{{ med.format }}</span>
                </div>
                <div class="float-right">
                    Qty: {{ med.available_qty}}<br>
                    <span class="badge badge-secondary">Exp: {{ med.exp_year}}/{{ med.exp_month}}</span>
                </div>
            </li>
        </ul>
        <div class="text-right" style="margin-top: 15px;">
            <button class="btn btn-primary" @click="newMedicine()">Add</button>
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
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="exp_year">Expire year</label>
                                        <input type="text" class="form-control" id="exp_year" v-model="medicine.exp_year">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="exp_month">Expire month</label>
                                        <select class="form-control" id="exp_month" v-model="medicine.exp_month">
                                            <option v-for="item in months" :key="item.value" :value="item.value">{{ item.label }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="available_qty">Available quantity</label>
                                <input type="text" class="form-control" id="available_qty" v-model="medicine.available_qty">
                                <small class="form-text text-muted">
                                    A number like 10, a percentage like 50% or anything you want.
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mr-auto" @click="delMedicine" v-show="medicine.id!==null">Del</button>
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
                    exp_year: null,
                    exp_month: null,
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
                ],
                months: [
                    {value: 1, label: 'Jan'},
                    {value: 2, label: 'Feb'},
                    {value: 3, label: 'Mar'},
                    {value: 4, label: 'Apr'},
                    {value: 5, label: 'May'},
                    {value: 6, label: 'Jun'},
                    {value: 7, label: 'Jul'},
                    {value: 8, label: 'Ago'},
                    {value: 9, label: 'Sep'},
                    {value: 10, label: 'Oct'},
                    {value: 11, label: 'Nov'},
                    {value: 12, label: 'Dec'},
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
            clearMedicine: function () {
                this.medicine.id = null;
                this.medicine.name = null;
                this.medicine.format = null;
                this.medicine.exp_year = null;
                this.medicine.exp_month = null;
                this.medicine.available_qty = null;
            },
            save: function () {
                console.log('Saving medicine...');

                // API request to save/update the user settings.
                // this.loading = true;
                // this.success = false;
                window.axios.post('api/medicine', this.medicine).then((response) => {
                    if (response.data.success) {
                        this.clearMedicine();
                        $('#modal-medicine').modal('hide');
                        this.fetchMedicines();

                        window.Toast.fire({
                            type: 'success',
                            title: 'Saved successfully!'
                        });
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
            newMedicine: function () {
                this.clearMedicine();
                $('#modal-medicine').modal('show');
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
                        this.medicine.exp_year = response.data.data.exp_year;
                        this.medicine.exp_month = response.data.data.exp_month;
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
            },
            delMedicine: function () {
                window.Swal.fire({
                    type: 'warning',
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {
                        window.axios.delete('api/medicine/' + this.medicine.id).then((response) => {
                            if (response.data.success) {
                                this.fetchMedicines();
                                this.clearMedicine();
                                $('#modal-medicine').modal('hide');

                                window.Toast.fire({
                                    type: 'success',
                                    title: response.data.message
                                });
                            }
                        });
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
