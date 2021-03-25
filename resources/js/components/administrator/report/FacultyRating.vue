<template>
    <div>
        <section class="section">
            <div class="container">

                <div class="header">
                    <div class="logo">
                        <img src="">
                    </div>
                    <div class="school-header">
                        <div class="header-text">

                        </div>
                        <div class="address-text">
                            
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="box">
                            INSTRUCTOR
                        </div>
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

        }
    },
    methods: {
        getRating(){
            axios.get('/ajax/faculty-rating?code='+this.code).then(res=>{
                this.data = res.data;
            })
        }
    },
    mounted() {
        this.getRating();
    }
}
</script>

<style scoped>

</style>
