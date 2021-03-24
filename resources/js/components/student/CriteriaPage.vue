<template>
    <div>
        <div class="container mt-5">


            <form @submit.prevent="submit">

                <div class="columns">
                    <div class="column is-10 is-offset-1">
                        <div class="box">
                            <div class="criteria-header mb-3 container">
                                INSTRUCTOR INFORMATION
                            </div>
                            <div>
                                Instructor: {{ this.instructor.lname }}, {{ this.instructor.fname }} {{this.instructor.mname}}
                            </div>
                            <div>
                                Course: {{this.course.name}} - {{this.course.desc}}
                            </div>

                            <hr>

                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <div>
                                        <p class="heading">Highest Rating </p>
                                        <p class="is-4">
                                            <b-rate icon-pack="fa" v-model="setMaxScore"
                                                    disabled
                                                    spaced show-score
                                                    size="is-medium"></b-rate>
                                        </p>
                                    </div>
                                </div>

                                <div class="level-item has-text-centered">
                                    <div>
                                        <p class="heading">Lowest Rating </p>
                                        <p class="is-4">
                                            <b-rate icon-pack="fa" v-model="setLowScore"
                                                    disabled
                                                    spaced show-score
                                                    size="is-medium"></b-rate>
                                        </p>
                                    </div>
                                </div>

                            </div><!--level-->

                            <hr>

                            <div class="legend-container">
                                <p class="title is-6">LEGENDS</p>
                                <ul class="legends">
                                    <li>5 - Outstanding</li>
                                    <li>4 - Very Satisfactory</li>
                                    <li>3 - Satisfactory</li>
                                    <li>2 - UnSatisfactory</li>
                                    <li>1 - Poor</li>
                                </ul>
                            </div>




                        </div>
                        <div class="box" v-for="item in data" :key="item.category_id">
                            <div class="criteria-header mb-3 container">{{item.category}}</div>
                            <div class="columns" v-for="c in item.criteria" :key="c.criterion_id">
                                <div class="column is-8">
                                    <div class="container">
                                        <div class="ml-3" >
                                            {{c.criterion}}
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="container">
<!--                                        <b-select expanded placeholder="Rate"-->
<!--                                                type="is-primary" required-->
<!--                                                v-model="rate[c.criterion_id]"-->
<!--                                                icon-pack="fa" icon="star">-->
<!--                                            <option value="5">5</option>-->
<!--                                            <option value="4">4</option>-->
<!--                                            <option selected value="3">3</option>-->
<!--                                            <option value="2">2</option>-->
<!--                                            <option value="1">1</option>-->
<!--                                        </b-select>-->

                                        <b-field label="Rate me">
                                            <b-rate icon-pack="fa"
                                                    required
                                                    v-model="fields.rate['critid_'+c.criterion_id]"
                                                    spaced show-score
                                                    size="is-medium"></b-rate>
                                        </b-field>

                                    </div>
                                </div>
                            </div>
                            <div style="background-color: green; height: 3px;"></div>
                        </div><!--box-->



                    </div><!--column offset-->
                </div><!--columns-->



                <div class="columns">
                    <div class="column is-10 is-offset-1">

                        <div class="box">
                            <div class="criteria-header mb-3 container">Comments/Suggestions</div>
                            <div class="columns">
                                <div class="column">
                                    <div class="container">
                                        <b-field label="">
                                            <b-input type="textarea" v-model="fields.comment"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                            <div style="background-color: green; height: 3px;"></div>
                        </div><!--box-->
                    </div><!--column offset-->
                </div><!--columns-->



                <div class="columns">
                    <div class="column is-10 is-offset-1 is-10-mobile is-offset-1-mobile">
                        <div class="buttons is-right">
                            <button :class="btnClass" type="submit">SUBMIT RATING</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props:['scheduleCode', 'ayCode'],
    data(){
        return{
            data: {},
            fields: {
                // "comment":"test",
                // "ay_code":"202",
                rate: {
                    // "critid_57":4,
                    // "critid_58":5,
                    // "critid_59":4,
                    // "critid_60":4,
                    // "critid_61":4,
                    // "critid_62":4,
                    // "critid_63":4,
                    // "critid_64":3,
                    // "critid_65":4,
                    // "critid_66":3,
                    // "critid_67":4,
                    // "critid_68":4,
                    // "critid_69":4,
                    // "critid_70":5,
                    // "critid_71":5,
                    // "critid_72":4,
                    // "critid_73":4,
                    // "critid_74":5,
                    // "critid_75":4,
                    // "critid_76":4,
                    // "critid_77":4,
                    // "critid_78":4,
                    // "critid_79":5,
                    // "critid_80":4,
                    // "critid_81":4,
                    // "critid_82":4,
                    // "critid_83":4,
                    // "critid_84":5,
                    // "critid_85":4,
                    // "critid_86":4
                }
            },
            rate: {},
            errors: {},
            btnClass:{
                'button': true,
                'is-primary': true,
                'is-loading': false,
            },

            instructor: {},
            course: {},
            setMaxScore: 5,
            setLowScore: 1,

        }
    },
    methods: {
        getData(){
            axios.get('/ajax/criteria').then(res=>{
                if(res.data.length > 0){
                    this.data = res.data;
                    this.instructor.code = this.data[0].SchedInsCode;

                    if(this.instructor.code !== ''){
                        this.getInstructor();
                    }
                    //tiwasonon ni dere..
                }
            })
        },

        getInstructor(){
            axios.get('ajax/instructor?schedule=' + this.scheduleCode).then(res=>{
                if(res.data.length > 0)
                this.instructor = res.data;
                this.instructor.lname = res.data[0].InsLName;
                this.instructor.fname = res.data[0].InsFName;
                this.instructor.mname = res.data[0].InsMName;

                this.course.name = res.data[0].SubjName;
                this.course.desc = res.data[0].SubjDesc;
            });
        },


        submit(){
            this.btnClass["is-loading"] = true;

            this.fields.schedule_code = this.scheduleCode;
            this.fields.ay_code = this.ayCode;

            axios.post('/ajax/criteria', this.fields).then(res=> {
                this.errors = {};

                if(res.data[0].status === 'saved'){
                    this.alertSuccess('Successfully saved.');

                }

                this.btnClass["is-loading"] = false;
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                    if(this.errors.schedule_code){
                        this.alertError(this.errors.schedule_code[0]);
                    }else{
                        this.alertError('Please rate all the criteria');
                    }
                }
                this.btnClass["is-loading"] = false;
            });
        },

        redirectAfterSaved(){
            window.location = '/schedule';
        },

        alertError(msg) {
            this.$buefy.dialog.alert({
                title: 'Error',
                message: msg,
                type: 'is-danger',
                hasIcon: true,
                icon: 'times-circle',
                iconPack: 'fa',
                ariaRole: 'alertdialog',
                ariaModal: true,
            })
        },

        alertSuccess(msg) {
            this.$buefy.dialog.alert({
                title: 'INFORMATION',
                message: msg,
                type: 'is-success',
                hasIcon: true,
                icon: 'check',
                iconPack: 'fa',
                ariaRole: 'alertdialog',
                ariaModal: true,
                confirmText: 'OK',
                onConfirm: () => window.location = '/schedule'
            })
        }

    },


    created(){

    },

    computed: {

    },

    mounted() {
        this.getData();

    }
}
</script>

<style scoped>
    .criteria-header{
        font-weight: bold;
        border-bottom: 3px solid green;
    }

    .legend-container{
        padding: 10px;
    }

    .legends{

    }

    .legends > li{
        display: inline-block;

        margin: 10px;
        font-weight: bold;
    }


    @media only screen and (max-width: 600px) {
        .legends > li{
            font-weight: bold;
            display: block;

            margin: 10px;
        }
    }
</style>
