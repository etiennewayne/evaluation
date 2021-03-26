<template>
    <div>
        <section class="section">
            <div class="container">

                <div class="header">
                    <div class="logo">
                        <img src="/img/logo_small.png" width="70">
                    </div>
                    <div class="school-header">
                        <div class="header-text">
                            GOV. ALFONSO D. TAN COLLEGE
                        </div>
                        <div class="address-text">
                            Maloro, Tangub City, Misamis Occidental
                        </div>
                    </div>
                </div>

                <div class="school-header mt-3 mb-5">
                    <div class="header-text">TEACHER PERFORMANCE EVALUATION RESULT</div>
                    <div class="header-text">{{ this.aydesc}}</div>
                </div>

                <div class="mybox">
                    <div class="is-flex is-flex-direction-column">
                        <div><strong>INSTRUCTOR:</strong> {{this.instructor }}</div>
                        <div><strong>INSTITUTE:</strong> {{ this.institute }}</div>
                        <div><strong>NO OF STUDENTS:</strong> {{ this.noOfStudent }}</div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="mybox">
                            <div class="is-flex is-flex-direction-column">
                                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth rating-table">
                                    <thead>
                                        <tr>
                                            <th>SCHEDULE CODE</th>
                                            <th>COURSE</th>
                                            <th>RATERS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in this.data" :key="item.id">
                                            <td>{{ item.SchedCode }}</td>
                                            <td>{{ item.SubjName }}</td>
                                            <td>{{ percentageForm(item.no_of_raters, item.no_students) }}</td>
                                        
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!--TABLE FOR RATING-->
                    <div class="column">
                        <div class="mybox">
                            <div class="is-flex is-flex-direction-column">
                                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth rating-table">
                                    <thead>
                                        <tr>
                                            <th>CATEGORY</th>
                                            <th>AVERAGE RATE</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in this.ratings" :key="item.id">
                                            <td>{{ item.category }}</td>
                                            <td>{{ item.avrg }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div><!--clumns-->

                
                
                


            </div>
        </section>
    </div>
</template>

<script>
export default {
    props: ['code'],
    data(){
        return{
            data: {},
            ratings: {},

            aydesc: '',

            instructor: '',
            institute: '',
            noOfStudent: '',

            finalRating: 0,
            legend: '',


        }
    },
    methods: {
        getRater(){
            axios.get('/ajax/faculty-rater?code='+this.code).then(res=>{

                if(res.data.length > 0){
                    this.data = res.data;

                    this.aydesc = this.data[0].ay_desc;
                    this.instructor = this.data[0].InsLName + ', ' + this.data[0].InsFName + ' ' + this.data[0].InsMName;
                    this.institute = this.data[0].InsDept;

                    this.noOfStudent =  this.percentageForm(this.data[0].total_rated, this.data[0].total_raters);
                }
            })
        },

        getRating(){
            axios.get('/ajax/faculty-rating?code='+this.code).then(res=>{

                if(res.data.length > 0){
                    this.ratings = res.data;

                    if(res.data.length > 0){

                    }

        
                    //this.finalRating = this.data[0].

                }
            })
        },


        percentageForm(rated, raters){
            let p = (rated/raters) * 100;
            return rated + '/'+raters + ' ('+Math.round(p * 100) /100 + '%)';
        }
    },
    mounted() {
        
        this.getRater();
        this.getRating();
    }
}
</script>

<style scoped>
    .header{
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
    }
    .header-text{
        text-align: center;
        font-weight: bold;
    }

    .school-header{
        display: flex;
        justify-content: center;
        flex-direction: column;

    }

    .mybox{
        width: 100%;
    }

    

    @media print {
        .rating-table thead tr th {
            font-size: 12px;
        }

        .rating-table thead tr th:nth-child(0) {
            font-size: 9px;
            width: 120px;
        }
    }



</style>
