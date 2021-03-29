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
                    <div class="is-flex">
                        <div class="is-flex is-flex-direction-column flex-grow">
                            <div><strong>INSTRUCTOR:</strong> {{this.instructor }}</div>
                            <div><strong>INSTITUTE:</strong> {{ this.institute }}</div>
                            <div><strong>NO OF STUDENTS:</strong> {{ this.noOfStudent }}</div>
                        </div>
                        <div class="back-flex flex-grow">
                            <b-button tag="a" href="/cpanel-report/faculty-report" type="is-danger" icon-pack="fa" icon-left="chevron-left">BACK</b-button>
                            <b-button type="is-primary" style="margin-left: 10px;" icon-pack="fa" icon-left="print" @click="printMe">PRINT</b-button>
                        </div>
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
                                        <tr>
                                            <td><strong>ASSESSTMENT</strong></td>
                                            <td><strong>{{ this.finalRating }} ({{ this.legend }})</strong></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>

                </div><!--columns-->


                <div class="columns">
                    <div class="column">
                        <!--labad sa ulo ni sia dere-->
                        <div class="remarks">REMARK/SUGGESTION</div>

                        <div>
                            <table class="table-remark">
                                <tr v-for="c in this.chunk(this.suggestions, 2)" :key="c.index">
                                    <td v-for="suggestion in c" :key="suggestion.index"><i class="fa fa-comment-o"></i> {{ suggestion.remark }}</td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div><!--close columns-->

                <div class="no-break">
                    <div class="signatory" v-for="item in this.signatories" :key="item.index">
                        <div class="noted">
                            {{ item.signatory_header }}
                        </div>

                        <div :class="groupSignature">
                            <div class="sign-name">
                                <div><img class="signature" :src="item.sign_path" /></div>
                                <div>{{ item.name }}</div>
                            </div>
                            <div class="sign-designation">
                                {{ item.designation }}
                            </div>
                        </div>
                    </div>

                    <!-- <div class="signatory">
                        <div class="noted">
                            {{ this.signHeader[1] }}
                        </div>
                        <div :class="group-signature">
                            <div class="sign-name">
                                <div><img class="signature" :src="this.signPath[1]" /></div>
                                <div>{{ this.signName[1] }}</div>
                            </div>
                            <div class="sign-designation">
                                VP for Academic Affairs
                            </div>
                        </div>
                        
                    </div> -->

                </div>
                

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

            suggestions:{},
            itemsPerRow: 2,

            signatories: {},
            signHeader: [],
            signName: [],
            signDesignation: [],
            signPath: [],
            

            groupSignature: {
                'group-signature': true,
            }


        }
    },
    methods: {
        
        getRater(){
            axios.all(
                [
                    axios.get('/ajax/faculty-rater?code='+this.code), 
                    axios.get('/ajax/faculty-suggestion?code='+this.code),
                    axios.get('/ajax/faculty-rating?code='+this.code),
                    axios.get('/ajax/signatory')

                ]).then(axios.spread((...res)=>{
                
                    if(res[0].data.length > 0){

                        this.data = res[0].data;
                        this.aydesc = this.data[0].ay_desc;
                        this.instructor = this.data[0].InsLName + ', ' + this.data[0].InsFName + ' ' + this.data[0].InsMName;
                        this.institute = this.data[0].InsDept;

                        this.noOfStudent =  this.percentageForm(this.data[0].total_rated, this.data[0].total_raters);

                    }

                    if(res[1].data.length > 0){
                        this.suggestions = res[1].data;
                    }

                    if(res[2].data.length > 0){
                        this.ratings = res[2].data;
                        this.finalRating = this.ratings[0].total_avg;
                        this.legend = this.ratings[0].legend;
                    }

                    if(res[3].data.length > 0){
                        this.signatories = res[3].data;
                        // this.signHeader[0] = this.signatories[0].signatory_header;
                        // this.signHeader[1] = this.signatories[1].signatory_header;

                        // this.signName[0] = this.signatories[0].name;
                        // this.signName[1] = this.signatories[1].name;

                        // this.signPath[0] = this.signatories[0].sign_path;
                        // this.signPath[1] = this.signatories[1].sign_path;

                    }

            }))
        },



        

        chunk (arr, len) {

            const chunks = []
            let i = 0
            const n = arr.length

            while (i < n) {
                chunks.push(arr.slice(i, i += len))
            }

            return chunks
        },

        percentageForm(rated, raters){
            let p = (rated/raters) * 100;
            return rated + '/'+raters + ' ('+Math.round(p * 100) /100 + '%)';
        },

        printMe(){
            window.print();
        }
    },

    // computed: {
    //     chunked () {
    //         return _.chunk(this.suggestions, 2)
    //     },
    // },

    

    mounted() {
        
        this.getRater();
    
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
    .flex-grow{
        flex: 1;
    }

    .back-flex{
        display: flex;
        justify-content: flex-end;
    }
    .remarks{
        font-weight: bold;
    }

    .table-remark > tr > td{
        padding: 10px;
        border: 1px solid gray;
        width: 50%;
    }

    .signatory{
        width: 100%;
    }

    .noted{
        font-weight: bold;
        margin-top: 50px;
    }
    .signature{
        position:relative;
        top: 50px;
        width: 180px;
    }

    .sign-name{
        font-weight: bold;
        position: relative;   
        font-size: 16px;
        margin-left: 50px;
    }

   

    .sign-designation{
        font-weight: bold;
        font-size: 14px;
        margin-left: 50px;
    }

    .group-signature{
        position: relative;
        margin-top: -50px;
    }
 
    
    /*print css*/
    @media print {
        @page {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        /* @page:footer {
            display: none
        }
    
        @page:header {
            display: none
        } */

        /* body{
            padding-top: 72px;
            padding-bottom: 72px ;
        } */

        .rating-table thead tr th {
            font-size: 12px;
        }

        .rating-table thead tr th:nth-child(0) {
            font-size: 9px;
            width: 120px;
        }

         .back-flex{
            display: none;
        }

        .no-break{
            display: flex;
            flex-direction: column;
            break-inside: avoid;
        }

        .signatory{
            width: 100%;
        }

        .sign-name{
          
            font-weight: bold;
            font-size: 16px;
        }

        .sign-designation{
            font-weight: bold;
            font-size: 14px;
        }

        
    }



</style>
