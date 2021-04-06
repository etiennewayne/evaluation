<template>

    <div>

        <div class="container">
            <section class="section">
                <div class="is-flex is-justify-content-center mb-2 table-title" style="font-size: 20px; font-weight: bold;">ACADEMIC YEAR LIST</div>
                <div class="columns">
                    <div class="column is-8 is-offset-2">
                        <b-field label="Page">
                            <b-select v-model="perPage" @input="setPerPage">
                                <option value="5">5 per page</option>
                                <option value="10">10 per page</option>
                                <option value="15">15 per page</option>
                                <option value="20">20 per page</option>
                            </b-select>
                        </b-field>
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

                            <b-table-column field="ay_id" label="ID" v-slot="props">
                                {{ props.row.ay_id }}
                            </b-table-column>

                            <b-table-column field="ay_code" label="AY Code" searchable v-slot="props">
                                {{ props.row.ay_code }}
                            </b-table-column>

                            <b-table-column field="ay_desc" label="AY Description" searchable v-slot="props">
                                {{ props.row.ay_desc }}
                            </b-table-column>

                            <b-table-column field="active" label="Active" v-slot="props">
                                <div style="margin:0 auto;">
                                    <i v-if="props.row.active === 1" class="fa fa-check-circle" style="color:green;"></i>
                                    <i v-else class="fa fa-close" style="color:red;"></i>
                                </div>

                            </b-table-column>



                            <b-table-column field="ay_id" label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-button outlined class="button is-small is-warning mr-1" tag="a" icon-right="pencil" icon-pack="fa" @click="getData(props.row.ay_id)">EDIT</b-button>
                                    <b-button outlined class="button is-small is-danger mr-1" icon-pack="fa" icon-right="trash" @click="confirmDelete(props.row.ay_id)">DELETE</b-button>
                                    <b-button outlined class="button is-small is-success" icon-left="check-circle" icon-pack="fa" @click="markActive(props.row.ay_id)"></b-button>
                                </div>
                            </b-table-column>

                        </b-table>

                        <div class="buttons mt-3">
                        <!-- <b-button tag="a" href="/cpanel-academicyear/create" class="is-primary">Create Account</b-button> -->
                            <b-button @click="modalCreate" class="is-primary is-fullwidth">Create Account</b-button>
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
                            <p class="modal-card-title">Academic Year</p>
                            <button
                                type="button"
                                class="delete"
                                @click="isModalCreate = false"/>
                        </header>
                        <section class="modal-card-body">
                            <div class="">
                                <b-field label="Academic Year Code"
                                    :type="this.errors.ay_code ? 'is-danger':''"
                                    :message="this.errors.ay_code ? this.errors.ay_code[0] : ''">
                                    <b-input v-model="fields.ay_code"
                                            placeholder="Academic Year Code" required>
                                    </b-input>
                                </b-field>
                                <b-field label="Academic Year Description"
                                    :type="this.errors.ay_desc ? 'is-danger':''"
                                    :message="this.errors.ay_desc ? this.errors.ay_desc[0] : ''">
                                    <b-input v-model="fields.ay_desc"
                                            placeholder="Academic Year Description" required>
                                    </b-input>
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





            <!--modal update-->
            <!-- <b-modal v-model="isModalUpdate" has-modal-card
                trap-focus
                :width="640"
                aria-role="dialog"
                aria-label="Example Modal"
                aria-modal>

                <form @submit.prevent="submit">
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Academic Year</p>
                            <button
                                type="button"
                                class="delete"
                                @click="isModalUpdate = false"/>
                        </header>
                        <section class="modal-card-body">
                            <div class="">
                                <b-field label="Academic Year Code"
                                    :type="this.errors.ay_code ? 'is-danger':''"
                                    :message="this.errors.ay_code ? this.errors.ay_code[0] : ''">
                                    <b-input v-model="updateFields.ay_code"
                                            placeholder="Academic Year Code" required>
                                    </b-input>
                                </b-field>
                                <b-field label="Academic Year Description"
                                    :type="this.errors.ay_desc ? 'is-danger':''"
                                    :message="this.errors.ay_desc ? this.errors.ay_desc[0] : ''">
                                    <b-input v-model="updateFields.ay_desc"
                                            placeholder="Academic Year Description" required>
                                    </b-input>
                                </b-field>
                            </div>
                        </section>
                        <footer class="modal-card-foot">
                            <b-button
                                label="Close"
                                @click="isModalUpdate=false"/>
                            <button
                                :class="btnClass"
                                label="Save"
                                type="is-success">SAVE</button>
                        </footer>
                    </div>

                </form>
            </b-modal> -->





        </div><!-- container-->
    </div><!--close root div>-->

</template>

<script>
export default {

    data() {
        return {
            data: [],
            total: 0,
            loading: false,
            sortField: 'ay_code',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',
            dataId: 0,

            isModalCreate: false,
            isModalUpdate: false,

            fields: {},
            updateFields: {},
            errors : {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

        }
    },
    methods: {
        /*
    * Load async data
    */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/api/academicyear?${params}`)
                .then(({ data }) => {
                    this.data = []
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

        editLink(link_id){
            return "/cpanel-academicyear/"+link_id+"/edit";
        },

        deleteSubmit(delete_id){
            axios.delete('/api/academicyear/'+ delete_id).then(res=>{
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
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },


        //save data
        submit(){
            this.btnClass['is-loading'] = true;

            if(this.dataId > 0){
                //update request
                axios.put('/api/academicyear/' + this.dataId, this.fields).then(res=>{
                    this.fields = {};
                    this.errors = {};
                    this.loadAsyncData()
                    this.btnClass['is-loading'] = false;
                    this.isModalCreate = false;
                    this.dataId = 0; //clear edit ID
                    this.fields = {}; //clear fields
                }).catch(err=>{
                    if(err.response.status===422){
                        this.errors = err.response.data.errors;
                    }

                    //console.log(err.response.status);
                    this.btnClass['is-loading'] = false;
                })

            }else{

                axios.post('/api/academicyear', this.fields).then(res=>{
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
            this.errors = {};

            this.dataId = data_id;

            this.isModalCreate = true;
            axios.get('/api/academicyear/'+data_id).then(res=>{
                this.fields = res.data;
                //console.log(res.data);
            })
        },


        //markActive the academic year
        markActive(id){
            axios.post('/api/academicyear-set-active', { 'id': id }).then(res=>{
                if(res.data[0].status === 'success'){
                    this.$buefy.dialog.alert({
                        title: 'SUCCESS!',

                        message: 'Set active successfully',
                        onConfirm: () => this.loadAsyncData()
                    });
                }

            });
        },

        modalCreate(){
            this.isModalCreate = true;
            this.fields = {};
            this.errors = {};
            this.dataId = 0;
        },

    },

    mounted() {
        this.loadAsyncData()
    }
}
</script>
