<template>
    <div>
        <div class="container mt-5">
            <div class="columns">
                <div class="column is-6 is-offset-3">

                    <div class="panel">
                        <div class="panel-heading">
                            <div class="level">
                                <div class="level-left">
                                    RATING
                                </div>
                                <div class="level-right">
                                    <b-button tag="a" class="" href="/schedule" icon-right="arrow-left" icon-pack="fa">BACK</b-button>
                                </div>
                            </div>
                            
                        </div>

                        <div class="p-4">
                            Instructor: {{ this.data[0].InsLName }}, {{ this.data[0].InsFName }} {{this.data[0].InsMName}}
                            <br>
                            Schedule Code: {{ this.data[0].schedule_code }}
                            <br>
                            Course: 
                        </div>
                        <div class="p-4">
                            <b-table
                                :data="data"
                                :paginated="isPaginated"
                                >

                                <b-table-column field="category" label="Category" v-slot="props">
                                    {{ props.row.category }}
                                </b-table-column>

                                <b-table-column field="n_rating" label="Rating" v-slot="props">
                                    {{ props.row.n_rating }}
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