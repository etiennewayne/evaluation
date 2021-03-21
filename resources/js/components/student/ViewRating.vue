<template>
    <div>
        <div class="container mt-5">
            <div class="columns">
                <div class="column is-6 is-offset-3">

                    <div class="panel">
                        <div class="panel-heading">
                            RATING
                        </div>
                        <div class="p-4">
                            <b-table
                                :data="data"
                                :paginated="isPaginated"
                                >

                                <b-table-column field="category" label="Category" v-slot="props">
                                    {{ props.row.category }}
                                </b-table-column>

                                <b-table-column field="rating_avg" label="Rating" v-slot="props">
                                    {{ props.row.rating_avg }}
                                </b-table-column>
                            </b-table>
                        </div>
                    </div><!--panel-->


                </div><!--column-->
            </div><!--columns-->
        </div><!--container-->
    </div><!--root div-->
</template>

<script>
export default {
    props: ['scheduleCode'],
    data(){
        return{
            data: [],
            isPaginated: false,
            
        }
    },

    methods: {
        getRating(){
            axios.get('/ajax/rating?schedule='+this.scheduleCode).then(res=>{
                this.data = res.data;

                console.log(this.data);
            })
        }
    },

    mounted(){
        this.getRating();
    },
}
</script>