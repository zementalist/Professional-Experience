<template>
    <div>
    <div class="background-infrastructure">
        <div class="ground">
            <div class="row">
                <div class="col-12 d-block d-md-none d-sm-none">
                    <div class="motto-contianer">
                        <h3 class="motto">Life's About Sharing</h3>
                    </div>
                </div>
            <div class="container-fluid" style="padding-left:15px;padding-right:15px;">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-12">
                        <br class="d-none d-md-block d-sm-block">
                        <br class="d-none d-md-block d-sm-block">
                        <br class="d-none d-md-block d-sm-block">
                        <img id="img1" src="../../images/cloudfiles.png" alt="logo" class="opt-image">
                        <br>
                        <div class="instruct1">
                            <h4 id="text">Upload & Share your files with friends, Fast & Free</h4>
                            <br class="d-none d-md-block">
                            <h4>No need for registration !</h4>
                            <br>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 d-none d-md-block d-sm-block">
                        <div class="motto-contianer">
                            <h3 class="motto" style="opacity:0">Life's About Sharing</h3>
                        </div>
                        <div class="motivate">
                            <div class="row">
                                <div class="col-12 col-md-12 col-sm-12">
                                    <br class="d-none d-md-block d-sm-block"><br class="d-none d-md-block d-sm-block">
                                    <br class="d-none d-md-block d-sm-block"><br class="d-none d-md-block d-sm-block">
                                    <br class="d-none d-md-block d-sm-block"><br class="d-none d-md-block d-sm-block">
                                    <br class="d-none d-md-block d-sm-block"><br class="d-none d-md-block d-sm-block">
                                    <h4>Click 'Upload now' and let the fire boost your file!</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3"></div>
                </div>
            </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-8 col-12 col-offset-6 mx-auto">
                        <router-link to="filetypes" style="color:white;"><button class="btn btn-primary up-btn">Upload now</button></router-link>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="upload-component-par">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>
