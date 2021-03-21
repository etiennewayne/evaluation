<template>
    <div>

        <div class="container is-widescreen mt-5">
            <div class="columns is-multiline">

                <div class="column is-4-desktop">
                    <div class="panel">
                        <div class="panel-heading">
                            COURSE INFORMATION
                        </div>
                        <div class="panel-block">

                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="panel">
                        <div class="panel-heading">
                            SCHEDULES
                        </div>
                        
                        <div class="p-4">
                            <b-table
                                :data="data"
                                :paginated="isPaginated"
                                :per-page="perPage"
                                :current-page.sync="currentPage"
                                :pagination-simple="isPaginationSimple"
                                :pagination-position="paginationPosition"
                                :default-sort-direction="defaultSortDirection"
                                :pagination-rounded="isPaginationRounded"
                                :sort-icon="sortIcon"
                                :sort-icon-size="sortIconSize"
                                default-sort="user.first_name"
                                aria-next-label="Next page"
                                aria-previous-label="Previous page"
                                aria-page-label="Page"
                                aria-current-label="Current page">

                                <b-table-column field="SchedCode" label="Schedule Code" sortable v-slot="props">
                                    {{ props.row.EnrSchedCode }}
                                </b-table-column>

                                <b-table-column field="SubjName" label="Course Code" sortable v-slot="props">
                                    {{ props.row.SubjName }}
                                </b-table-column>

                                <b-table-column field="SubjDesc" label="Course Description" sortable v-slot="props">
                                    {{ props.row.SubjDesc }}
                                </b-table-column>

                                <b-table-column field="SubjClass" label="Course Class" sortable v-slot="props">
                                    {{ props.row.subjClass }}
                                </b-table-column>

                                <b-table-column field="SchedTimeFrm" label="Start Time"  sortable v-slot="props">
                                    {{ props.row.SchedTimeFrm | formatTime }}
                                </b-table-column>

                                <b-table-column field="SchedTimeTo" label="End Time"  sortable v-slot="props">
                                    {{ props.row.SchedTimeTo | formatTime}}
                                </b-table-column>

                                <b-table-column field="SchedDays" label="Day"  sortable v-slot="props">
                                    {{ props.row.SchedDays }}
                                </b-table-column>

                                <b-table-column field="SchedSubjSet" label="Set"  sortable v-slot="props">
                                    {{ props.row.SchedSubjSet }}
                                </b-table-column>

                                <b-table-column field="SchedSubjSet" label="Action"  v-slot="props">
                                    <div class="buttons">
                                        <b-button v-if="props.row.nSchedule_Code !== null"  class="button is-small is-warning" tag="a" :href="`/view-rating?schedule=`+props.row.EnrSchedCode" icon-pack="fa" icon-right="tasks">RATING</b-button>
                                        <b-button v-else class="button is-small is-primary" tag="a" :href="`/criteria?schedule=`+props.row.EnrSchedCode" icon-pack="fa" icon-right="star">RATE</b-button>
                                    </div>
                                </b-table-column>
                            </b-table>
                        </div>
                        
                        
                    </div>
                </div><!--column-->
            </div>

        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            data: [],
            isPaginated: true,
            isPaginationSimple: false,
            isPaginationRounded: false,
            paginationPosition: 'bottom',
            defaultSortDirection: 'asc',
            sortIcon: 'arrow-up',
            sortIconSize: 'is-small',
            currentPage: 1,
            perPage: 15
        }
    },
    methods: {
        getData(){
            axios.get('/ajax/schedule').then(res=>{
                this.data = res.data;
                console.log(res.data);
            });
        }
    },
    mounted(){
        this.getData();
    },
}
</script>
