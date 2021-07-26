<template>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="component-infrastructure">
                    <div class="row">
                        <div id="form">

                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-lg-4">
                            <file-type iconClass="far fa-image" type="Image"></file-type>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-lg-4">
                            <file-type iconClass="far fa-file-video" type="Video"></file-type>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-lg-4">
                            <file-type iconClass="far fa-file-audio" type="Audio"></file-type>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-lg-4">
                            <file-type iconClass="fas fa-file-archive" type="Compressed"></file-type>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-lg-4">
                            <file-type iconClass="far fa-file-alt" type="Document"></file-type>
                        </div>
                        <div class="col-md-4 col-sm-4 col-4 col-lg-4">
                            <file-type iconClass="far fa-file" type="Other" style="opacity:0.5;"></file-type>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var substract = (window.innerWidth < 521 ? 0 : 720);
            var limit = document.documentElement.scrollHeight - substract;
            window.scrollTo(0,limit);
        },
        methods: {
            scrollDown() {
                var body = document.documentElement;
                var scrollRatio = 0.5;
                alert(document.documentElement.clientHeight);
                var loop = setInterval(function() {
                    body.scrollTop += scrollRatio;
                    scrollRatio += 0.1;
                    console.log('d');
                    if((body.scrollTop) >= (document.documentElement.clientHeight - document.getElementsByClassName('footer')[0].clientHeight)) {
                        clearInterval(loop);
                    }
                }, 20) 
            }
        }
    }
</script>
