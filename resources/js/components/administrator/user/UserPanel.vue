<template>
    <div>


        <section class="section">
            <div class="columns">
                <div class="column is-8 is-offset-2">
                    <div class="is-flex is-justify-content-center mb-2 table-title" style="font-size: 20px; font-weight: bold;">LIST OF USER</div>
                    <div class="level">
                        <div class="level-left">
                            <b-field label="Page">
                                <b-select v-model="perPage" @input="setPerPage">
                                    <option value="5">5 per page</option>
                                    <option value="10">10 per page</option>
                                    <option value="15">15 per page</option>
                                    <option value="20">20 per page</option>
                                </b-select>
                            </b-field>
                        </div>

                        <div class="level-right">
                            <div class="level-item">
                                <b-field label="Search">
                                    <b-input type="text"
                                        v-model="search" placeholder="Search Name"
                                        @keyup.native.enter="loadAsyncData"/>
                                    <p class="control">
                                        <b-button type="is-primary" label="Search" @click="loadAsyncData"/>
                                    </p>
                                </b-field>
                            </div>
                        </div>
                    </div>

                    <b-table
                        :data="data"
                        :loading="loading"
                        paginated
                        backend-pagination
                        :total="total"
                        :per-page="perPage"
                        @page-change="onPageChange"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page"
                        backend-sorting
                        :default-sort-direction="defaultSortDirection"
                        @sort="onSort">

                        <b-table-column field="id" label="ID" v-slot="props">
                            {{ props.row.id }}
                        </b-table-column>

                        <b-table-column field="username" label="Username" v-slot="props">
                            {{ props.row.username }}
                        </b-table-column>

                        <b-table-column field="name" label="Name" v-slot="props">
                            {{ props.row.name }}
                        </b-table-column>

                        <b-table-column field="email" label="Email" v-slot="props">
                            {{ props.row.email }}
                        </b-table-column>

                        <b-table-column field="userType" label="Role" v-slot="props">
                            {{ props.row.userType }}
                        </b-table-column>

                        <b-table-column field="institute" label="Office/Institute" v-slot="props">
                            {{ props.row.institute }}
                        </b-table-column>

                        <b-table-column field="ay_id" label="Action" v-slot="props">
                            <div class="is-flex">
                                <b-button outlined class="button is-small is-warning mr-1" tag="a" icon-right="pencil" icon-pack="fa" @click="getData(props.row.id)">EDIT</b-button>
                                <b-button outlined class="button is-small is-danger mr-1" icon-pack="fa" icon-right="trash" @click="confirmDelete(props.row.id)">DELETE</b-button>
                            </div>
                        </b-table-column>

                    </b-table>

                    <div class="buttons mt-3">
                        <!-- <b-button tag="a" href="/cpanel-academicyear/create" class="is-primary">Create Account</b-button> -->
                        <b-button @click="openModal" class="is-primary is-fullwidth">Create User</b-button>
                    </div>
                </div><!--close column-->
            </div>
        </section>



            <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Example Modal"
                 aria-modal>

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">User Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="fiel">
                            <b-field label="Username" label-position="on-border"
                                     :type="this.errors.username ? 'is-danger':''"
                                     :message="this.errors.username ? this.errors.username[0] : ''">
                                <b-input v-model="fields.username"
                                         placeholder="Username" required>
                                </b-input>
                            </b-field>

                            <b-field label="Name" label-position="on-border"
                                     :type="this.errors.name ? 'is-danger':''"
                                     :message="this.errors.name ? this.errors.name[0] : ''">
                                <b-input v-model="fields.name"
                                         placeholder="Name" required>
                                </b-input>
                            </b-field>

                            <b-field label="Email" label-position="on-border"
                                     :type="this.errors.email ? 'is-danger':''"
                                     :message="this.errors.email ? this.errors.email[0] : ''">
                                <b-input v-model="fields.email"
                                         placeholder="Email" required>
                                </b-input>
                            </b-field>

                            <b-field label="Password" label-position="on-border"
                                     :type="this.errors.password ? 'is-danger':''"
                                     :message="this.errors.password ? this.errors.password[0] : ''">
                                <b-input v-model="fields.password"
                                         placeholder="Password" required>
                                </b-input>
                            </b-field>

                            <b-field label="Confirm Password" label-position="on-border"
                                     :type="this.errors.password_confirmation ? 'is-danger':''"
                                     :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                <b-input v-model="fields.password_confirmation"
                                         placeholder="Confirm Password" required>
                                </b-input>
                            </b-field>

                            <b-field grouped>
                                <b-field label="Role" label-position="on-border">
                                    <b-select v-model="fields.userType">
                                        <option value="ADMIN">ADMINISTRATOR</option>
                                        <option value="USER">USER</option>
                                    </b-select>
                                </b-field>

                                <b-field label="Institute" label-position="on-border">
                                    <b-select v-model="fields.institute">
                                        <option value="ICS">ICS</option>
                                        <option value="IAS">IAS</option>
                                        <option value="HR">HR</option>
                                        <option value="HR">CISO</option>
                                    </b-select>
                                </b-field>

                            </b-field>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="isModalCreate=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>

            </form><!--close form-->
        </b-modal>


    </div>
</template>

<script>
export default {

    data() {
        return {
            data: [],
            total: 0,
            loading: false,
            sortField: 'id',
            sortOrder: 'desc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',

            isModalCreate: false,

            dataId: 0,
            fields: {},
            errors : {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            search: '',
        }
    },
    methods: {
        /*
    * Load async data
    */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `name=${this.search}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/ajax/user?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
    * Handle page-change event
    */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },

        //actions here below

        deleteSubmit(delete_id){
            axios.delete('/ajax/user/'+ delete_id).then(res=>{
                this.loadAsyncData();
            }).catch(err=>{
                console.log(err);
            });
        },



        //alert
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete Account',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },


        //save data
        submit(){
            this.btnClass['is-loading'] = true;
            if(this.dataId > 0){
                //update data
                axios.put('/ajax/user/'+ this.dataId, this.fields).then(res=>{
                    this.fields = {};
                    this.errors = {};
                    this.loadAsyncData()
                    this.btnClass['is-loading'] = false;
                    this.isModalCreate = false;
                }).catch(err=>{
                    if(err.response.status===422){
                        this.errors = err.response.data.errors;
                    }

                    //console.log(err.response.status);
                    this.btnClass['is-loading'] = false;
                })
            }else{
                axios.post('/ajax/user', this.fields).then(res=>{
                    this.fields = {};
                    this.errors = {};
                    this.loadAsyncData()
                    this.btnClass['is-loading'] = false;
                    this.isModalCreate = false;
                }).catch(err=>{
                    if(err.response.status===422){
                        this.errors = err.response.data.errors;
                    }

                    //console.log(err.response.status);
                    this.btnClass['is-loading'] = false;
                })
            }


        },



        //getData
        getData(data_id){
            this.fields = {};
            this.isModalCreate = true;
            this.dataId = data_id;

            axios.get('/ajax/user/'+data_id).then(res=>{
                this.fields = res.data[0];
                //console.log(res.data[0]);
            })
        },

        openModal(){
            this.isModalCreate=true;
            this.fields = {};
            this.errors = {};

        }



    },

    mounted() {
        this.loadAsyncData()
    }
}
</script>

<style scoped>

</style>
