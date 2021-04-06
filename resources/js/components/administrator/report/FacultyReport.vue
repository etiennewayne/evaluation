<template>
    <div>
        <section class="section">

            <div class="columns">
                <div class="column is-8 is-offset-2">
                    <div class="is-flex is-justify-content-center mb-2 table-title" style="font-size: 20px; font-weight: bold;">LIST OF FACULTY</div>
                    <div class="level">
                        <div class="level-left">
                            <b-field label="Page">
                                <b-select v-model="perPage" @input="setPerPage">
                                    <option value="5">5 per page</option>
                                    <option value="10">10 per page</option>
                                    <option value="15">15 per page</option>
                                    <option value="20">20 per page</option>
                                    <option value="30">30 per page</option>
                                    <option value="40">40 per page</option>
                                </b-select>
                            </b-field>
                        </div>
                        <div class="level-right">
                            <b-field label="Search">
                                <b-input type="text" v-model="lastname" @keyup.native.enter="loadAsyncData" placeholder="Lastname"></b-input>
                                <p class="control"><button class="button is-primary" @click="loadAsyncData">SEARCH</button></p>
                            </b-field>
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

                        <b-table-column field="InsCode" label="ID" v-slot="props">
                            {{ props.row.InsCode }}
                        </b-table-column>

                        <b-table-column field="InsLName" label="Lastname" v-slot="props">
                            {{ props.row.InsLName }}
                        </b-table-column>

                        <b-table-column field="InsFName" label="Firstname" v-slot="props">
                            {{ props.row.InsFName }}
                        </b-table-column>

                        <b-table-column field="InsMName" label="Middlename" v-slot="props">
                            {{ props.row.InsMName }}
                        </b-table-column>

                        <b-table-column field="ay_id" label="Action" v-slot="props">
                            <div class="is-flex">
                                <b-button outlined class="button is-small is-primary mr-1" tag="a" icon-right="star" icon-pack="fa" @click="getRating(props.row.InsCode)">RATING</b-button>
                            </div>
                        </b-table-column>
                    </b-table>
                </div>
            </div>
        </section>
    </div><!--div root-->
</template>

<script>
export default {
    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'InsLName',
            sortOrder: 'asc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',

            lastname: '',


        }
    },

    methods: {
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`,
                `lastname=${this.lastname}`
            ].join('&')

            this.loading = true
            axios.get(`/ajax/faculty?${params}`)
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

        getRating(data_id){
            window.location = '/cpanel-report/faculty-rating?code='+data_id;
        },




    },

    mounted(){
        this.loadAsyncData();
    },
}
</script>

<style scoped>
    .table-header{
        margin: auto;
        text-align: center;
    }
</style>
