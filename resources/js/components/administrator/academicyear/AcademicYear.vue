<template>

    <div>
        
        <div class="container">
            <section class="section">
                <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST ACADEMIC YEAR</div>
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

                            <b-table-column field="ay_id" label="ID" searchable v-slot="props">
                                {{ props.row.ay_id }}
                            </b-table-column>

                            <b-table-column field="ay_code" label="AY Code" searchable v-slot="props">
                                {{ props.row.ay_code }}
                            </b-table-column>

                            <b-table-column field="ay_desc" label="AY Description" searchable v-slot="props">
                                {{ props.row.ay_desc }}
                            </b-table-column>

                            <b-table-column field="lname" label="Active" v-slot="props">
                                {{ props.row.active }}
                            </b-table-column>

                           

                            <b-table-column field="ay_id" label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-button class="button is-small is-warning mr-1" tag="a" icon-right="pencil" icon-pack="fa" :href="editLink(props.row.ay_id)">EDIT</b-button>
                                    <b-button class="button is-small is-danger" icon-pack="fa" icon-right="trash" @click="confirmDelete(props.row.ay_id)">DELETE</b-button>
                                </div>
                            </b-table-column>

                        </b-table>

                        <div class="buttons">
                            <!-- <b-button tag="a" href="/cpanel-academicyear/create" class="is-primary">Create Account</b-button> -->
                            <b-button @click="isModalCreate=true" class="is-primary">Create Account</b-button>
                        </div>

                    </div><!--close column-->
                </div>
            </section>


            <b-modal v-model="isModalCreate" has-modal-card
                trap-focus 
                :width="640"
                aria-role="dialog"
                aria-label="Example Modal"
                aria-modal>

                <form @submit="submit.prevent">
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
                            <b-field label="AY Code">
                                <b-input v-model="fields.ay_code"
                                        placeholder="Academic Year Code" required>
                                </b-input>
                            </b-field>
                            <b-field label="AY Description">
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
                            <b-button
                                label="Save"
                                type="is-success" />
                        </footer>
                    </div>

                </form><!--close form-->
            </b-modal>



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

            isModalCreate: false,

            fields: {},
            errors : {},

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
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
               //console.log(err);
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



        submit(){

        },

        


    },

    mounted() {
        this.loadAsyncData()
    }
}
</script>
