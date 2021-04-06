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
            <b-navbar-item href="/">
                Home
            </b-navbar-item>
            <b-navbar-item href="#">
                FAQ
            </b-navbar-item>
            <b-navbar-dropdown label="Others">
                <b-navbar-item href="/login">
                    Student
                </b-navbar-item>
                <b-navbar-item href="/cpanel">
                    GADTC
                </b-navbar-item>
            </b-navbar-dropdown>
<!--           <b-navbar-item tag="div">-->
<!--                <div class="buttons">-->
<!--                    <a class="button is-primary" href="/login">-->
<!--                        <strong>Log in</strong>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </b-navbar-item>-->
        </template>
    </b-navbar>

</template>

<script>
export default {

    data(){
        return{

        }
    },


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

