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
                        <div> INSTRUCTOR :{{this.instructor }}</div>
                        <div>INSTITUTE: {{ this.institute }}</div>
                        <div>NO OF STUDENTS: {{ this.noOfStudent }}</div>
                    </div>

                </div>

                <div class="mybox">
                    <div class="is-flex is-flex-direction-column">
                        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth rating-table">
                            <thead>
                                <tr>
                                    <th width="150">Course</th>
                                    <th>No of Raters</th>
                                    <th>Course Design</th>
                                    <th>Content</th>
                                    <th>Process</th>
                                    <th>Outcomes</th>
                                    <th>Personal Qualities and Professionalism</th>
                                    <th>Assessment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in this.data" :key="item.id">
                                    <td>{{ item.SubjName }}</td>
                                    <td>{{ item.no_of_raters }}</td>
                                    <td>{{ Math.round(item.course_design * 100) / 100 }}</td>
                                    <td>{{ Math.round(item.content * 100) / 100 }}</td>
                                    <td>{{ Math.round(item.process * 100) / 100 }}</td>
                                    <td>{{ Math.round(item.outcomes * 100)/ 100 }}</td>
                                    <td>{{ Math.round(item.personal_quality * 100) / 100 }}</td>
                                    <td>{{ Math.round(item.avg_category * 100) / 100 }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
            aydesc: '',

            instructor: '',
            institute: '',
            noOfStudent: '',


        }
    },
    methods: {
        getRating(){
            axios.get('/ajax/faculty-rating?code='+this.code).then(res=>{

                if(res.data.length > 0){
                    this.data = res.data;

                    this.aydesc = this.data[0].ay_desc;
                    this.instructor = this.data[0].InsLName + ', ' + this.data[0].InsFName + ' ' + this.data[0].InsMName;
                    this.institute = this.data[0].InsDept;

                    this.noOfStudent = this.data[0].no_of_raters + '/'+this.data[0].no_students;
                }
            })
        }
    },
    mounted() {
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

    .rating-table > th{
        font-size: 8px;
    }

    @media only screen and (max-width: 640px) {
        body {
            background-color: lightblue;
        }
    }



</style>
