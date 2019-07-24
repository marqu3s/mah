<template>
    <section v-if="errored">
        <p>We're sorry but we are unable to fetch your settings at this moment. Please try again later.</p>
    </section>

    <section v-else>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $t('UI_SETTINGS.settings') }}
                        <div class="spinner-grow spinner-grow-sm text-primary float-right" role="status" v-show="loading">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="POST" @submit.prevent="save" novalidate>
                            <div class="form-group row">
                                <label for="language" class="col-md-6 col-form-label text-md-right">{{ $t('UI_SETTINGS.language') }}</label>

                                <div class="col-md-6">
                                    <select id="language" class="form-control" name="language" v-validate="'required'" v-model="settings.language">
                                        <option v-for="lang in this.$parent.availableLanguages" :key="lang.code" :value="lang.code">{{ lang.label }}</option>
                                    </select>
                                    <span v-show="errors.has('language')" class="text-danger" role="alert">
                                        {{ errors.first('language') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ $t('UI_GENERAL.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: 'UserSettingsComponent',
        data: function () {
            return {
                settings: {
                    id: 0,
                    user_id: 0,
                    language: 'en',
                    initial_balance: '',
                    created_at: '',
                    updated_at: '',
                },
                errored: false,
                loading: true,
            }
        },
        props: {
            userId: {
                type: String,
                required: true
            }
        },
        created: function() {
            console.log('UserSettings Component Created... (userId: ' + this.$props.userId + ')');
        },
        mounted: function(){
            console.log('UserSettings component loaded...');
            this.fetchUserSettings();
        },
        methods: {
            fetchUserSettings: function () {
                console.log('Fetching User Settings...');

                // API request to load the current user settings.
                window.axios.get('api/user-setting/' + this.$props.userId).then((response) => {
                    this.settings.id = response.data.data.id;
                    this.settings.user_id = response.data.data.user_id;
                    this.settings.language = response.data.data.language;
                    this.settings.initial_balance = response.data.data.initial_balance;
                }).catch((error) => {
                    this.errored = true;
                    console.error(error);
                }).finally(() => this.loading = false);
            },
            save: function() {
                console.log('Saving User Settings...');

                // Parameters that will be sent with the request.
                let params = Object.assign({}, this.settings);

                // API request to save/update the user settings.
                this.loading = true;
                this.success = false;
                window.axios.put('api/user-setting/' + this.$props.userId, params).then((response) => {
                    if (response.data.success) {
                        this.settings.initial_balance = response.data.data.initial_balance;
                        window.Toast.fire({
                            type: 'success',
                            title: response.data.message
                        });
                        if (this.settings.language !== this.$parent.$options.i18n.locale) {
                            this.$parent.$options.i18n.locale = this.settings.language;
                        }
                    } else {
                        this.errored = true;
                    }
                }).catch((error) => {
                    this.errored = true;
                    console.error(error);
                }).finally(() => this.loading = false);
            },
        }
    }
</script>

<style scoped>
</style>
