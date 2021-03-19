<template>

    <div>
        <div class="hero is-fullheight-with-navbar">
            <div class="hero-body ">
                <div class="container has-text-centered">

                    <div class="welcome-text animate__animated animate__backInLeft">WELCOME TO FACULTY PERFORMANCE EVALUATION SYSTEM</div>
                    <div class="buttons is-centered animate__animated animate__backInLeft">
                        <a class="button is-primary is-outlined" href="/login">LOGIN</a>
                    </div>

                </div>
            </div>
        </div>
    </div><!--root div-->
</template>

<script>
export default {

    data(){
        return{
            fields: {},

        }
    },

    methods: {
        // submit(){
        //     axios.post('/login', this.fields).then(res=>{
        //         this.fields ={};
        //
        //     });
        // }
    }
}
</script>

<style scoped>

.welcome-text{
    font-size: 30px;
    font-weight: bold;
}



@media only screen and (max-width: 768px) {

}


</style>
