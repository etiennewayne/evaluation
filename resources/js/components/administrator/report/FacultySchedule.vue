<template>
    <div>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column is-8 is-offset-2">
                        <div class="title is-4 table-header">FACULTY SCHEDULE</div>
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
                                {{ props.row.SchedCode }}
                            </b-table-column>

                            <b-table-column field="SchedCourse" label="Program" v-slot="props">
                                {{ props.row.SchedCourse }}
                            </b-table-column>

                            <b-table-column field="SubjName" label="Course" v-slot="props">
                                {{ props.row.SubjName }}
                            </b-table-column>

                            <b-table-column field="SubjDesc" label="Course Desc" v-slot="props">
                                {{ props.row.SubjDesc }}
                            </b-table-column>


                            <b-table-column field="ay_id" label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-button outlined class="button is-small is-primary mr-1" tag="a" icon-right="star" icon-pack="fa" @click="getRating(props.row.SchedCode)">RATING</b-button>
                                </div>
                            </b-table-column>

                        </b-table>
                    </div>
                </div>
            </div>
        </section>
    </div><!--div root-->
</template>

<script>
export default {
    props: ['code'],
    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'SchedCode',
            sortOrder: 'asc',
            page: 1,
            perPage: 10,
            defaultSortDirection: 'asc',

        }
    },

    methods: {
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`,
                `code=${this.code}`,
            ].join('&')

            this.loading = true
            axios.get(`/ajax/faculty-schedule?${params}`)
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

        getRating(schedcode){
            return window.location = '/cpanel-report/faculty-rating?code=' +this.code+'&schedule='+schedcode;
        }

    },

    mounted(){
        this.loadAsyncData();
    },
}
</script>

<style scoped>

</style>
