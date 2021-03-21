<template>
    <b-navbar class="navbar is-primary">
        <template #brand>
            <b-navbar-item>
                <img
                    src="/img/logo_small.png"
                    alt="Gov. Alfonso D. Tan College"
                >
                <div>
                    <div class="brand-title-desktop">GOV. ALFONSO D. TAN COLLEGE</div>
                    <div class="brand-subtitle-desktop">FACULTY PERFORMANCE EVALUATION SYSTEM</div>

                    <div class="brand-title-mobile">GADTC</div>
                    <div class="brand-subtitle-mobile">FPES</div>
                </div>

            </b-navbar-item>
        </template>
        <template #start>

        </template>

        <template #end>
            <b-navbar-item href="/home">
                Home
            </b-navbar-item>
            <b-navbar-item href="faq">
                FAQ
            </b-navbar-item>
            <b-navbar-dropdown :label="userId">
                <b-navbar-item href="/schedule">
                    Schedules
                </b-navbar-item>
                <!-- <b-navbar-item href="">
                    Change Password
                </b-navbar-item> -->
            </b-navbar-dropdown>

            <b-navbar-item tag="div">
                <div class="buttons">
                    <b-button type="is-primary" icon-right="sign-out" icon-pack="fa" @click="logout">
                        <strong>Logout</strong>
                    </b-button>
                </div>
            </b-navbar-item>
        </template>
    </b-navbar>



</template>

<script>
export default {
    props: ['userId'],
    data(){
        return{

        }
    },
    methods:{
        logout(){
            axios.post('/logout').then(res =>{
                window.location = '/';
            })
        },

    }


}
</script>
<style scoped>

.brand-title-desktop{
    font-weight: bold;
    display: block;
}
.brand-subtitle-desktop{
    font-size: 14px;
    display: block;
}

.brand-title-mobile{
    font-weight: bold;
    display: none;
}
.brand-subtitle-mobile{
    font-size: 14px;
    display: none;
}

@media only screen and (max-width: 768px) {
    .brand-title-desktop{
        font-weight: bold;
        display: none;
    }
    .brand-subtitle-desktop{
        font-size: 14px;
        display: none;
    }

    .brand-title-mobile{
        font-weight: bold;
        display: block;
    }
    .brand-subtitle-mobile{
        font-size: 14px;
        display: block;
    }
}
</style>

