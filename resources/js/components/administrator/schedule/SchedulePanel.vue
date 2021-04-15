<template>
    <div>
        <section class="section">

            <div class="columns">
                <div class="column is-10 is-offset-1">
                    <div class="is-flex is-justify-content-center mb-2 table-title" style="font-size: 20px; font-weight: bold;">LIST OF SCHEDULES</div>
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
                            <b-field label="Schedulue Code">
                                <b-input type="text" v-model="schedCode" @keyup.native.enter="loadAsyncData" placeholder="Schedule Code"></b-input>
                                <p class="control"><button class="button is-primary" @click="loadAsyncData">Schedule Code</button></p>
                            </b-field>
                        </div>
                        <div class="level-right">
                            <b-field label="Faculty(Lastname)">
                                <b-input type="text" v-model="fLname" @keyup.native.enter="loadAsyncData" placeholder="Faculty(Lastname)"></b-input>
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

                        <b-table-column field="SchedCode" label="Schedule Code" v-slot="props">
                            {{ props.row.SchedCode }}
                        </b-table-column>

                        <b-table-column field="SubjName" label="Course Name" v-slot="props">
                            {{ props.row.SubjName }}
                        </b-table-column>

                        <b-table-column field="SchedTimeFrm" label="From" v-slot="props">
                            {{ props.row.SchedTimeFrm | formatTime }}
                        </b-table-column>

                        <b-table-column field="SchedTimeTo" label="To" v-slot="props">
                            {{ props.row.SchedTimeTo | formatTime }}
                        </b-table-column>

                        <b-table-column field="SchedDays" label="Days" v-slot="props">
                            {{ props.row.SchedDays }}
                        </b-table-column>

                        <b-table-column field="SchedInsCode" label="Code" v-slot="props">
                            {{ props.row.InsCode }}
                        </b-table-column>

                        <b-table-column field="status" label="Status" v-slot="props">
                            <b-icon v-if="props.row.allow_rate == 1"
                                    pack="fa"
                                    icon="check"
                                    type="is-success"
                                    size="is-small">
                            </b-icon>
                            <b-icon v-else
                                    pack="fa"
                                    icon="times-circle"
                                    type="is-danger"
                                    size="is-small">
                            </b-icon>
                        </b-table-column>

                        <b-table-column field="SchedSubjSet" label="Set" v-slot="props">
                            {{ props.row.SchedSubjSet }}
                        </b-table-column>

                        <b-table-column field="instructor_name" label="Instructor Name" v-slot="props">
                            {{ props.row.InsLName }}, {{ props.row.InsFName }} {{ props.row.InsMName }}
                        </b-table-column>

                        <b-table-column field="allow_rate" label="Action" v-slot="props">
                            <div class="is-flex">
                                <b-button v-if="props.row.allow_rate == 0" class="button is-small is-primary mr-1" tag="a" icon-right="check" icon-pack="fa" @click="openRate(props.row.SchedCode)">OPEN</b-button>
                                <b-button v-if="props.row.allow_rate == 1" class="button is-small is-danger mr-1" tag="a" icon-right="times-circle" icon-pack="fa" @click="closeRate(props.row.SchedCode)">CLOSE</b-button>
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
            sortField: 'SchedCode',
            sortOrder: 'asc',
            page: 1,
            perPage: 20,
            defaultSortDirection: 'asc',

            schedCode: '',
            fLname: '',
        }
    },

    methods: {
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`,
                `code=${this.schedCode}`,
                `lname=${this.fLname}`
            ].join('&')

            this.loading = true
            axios.get(`/ajax/cpanel/schedule?${params}`)
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

        openRate(schedcode){
            axios.put('/open/rate/'+schedcode).then(res=>{
                this.loadAsyncData();
            })
        },
        closeRate(schedcode){
            axios.put('/close/rate/'+schedcode).then(res=>{
                this.loadAsyncData();
            })
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
