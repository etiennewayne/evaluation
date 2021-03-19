<template>
    <div>
        <div class="container mt-5">


            <form @submit.prevent="submit">

                <div class="columns">
                    <div class="column is-10 is-offset-1">

                        <div class="box" v-for="(item, id) in data">
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

                                        <b-field :label="`Rating`+c.criterion_id">
                                            <b-rate icon-pack="fa"
                                                    required
                                                    v-model="rate['critid_'+c.criterion_id]"
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
                                            <b-input type="textarea" v-model="rate.comment"></b-input>
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
            rate: {},
            errors: {},
            btnClass:{
                'button': true,
                'is-primary': true,
                'is-loading': false,
            },
        }
    },
    methods: {
        getData(){
            axios.get('/ajax/criteria').then(res=>{
                this.data = res.data;
            })
        },


        submit(){
            this.btnClass["is-loading"] = true;
            this.rate.schedule_code = this.scheduleCode;
            this.rate.ay_code = this.ayCode;
            axios.post('/ajax/criteria', this.rate).then(res=> {
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

        alertError(msg) {
            this.$buefy.dialog.alert({
                title: 'Error',
                message: msg,
                type: 'is-danger',
                hasIcon: true,
                icon: 'times-circle',
                iconPack: 'fa',
                ariaRole: 'alertdialog',
                ariaModal: true
            })
        },

        alertSuccess(msg) {
            this.$buefy.dialog.alert({
                title: 'Error',
                message: msg,
                type: 'is-success',
                hasIcon: true,
                icon: 'check',
                iconPack: 'fa',
                ariaRole: 'alertdialog',
                ariaModal: true
            })
        }

    },


    created(){

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
</style>
