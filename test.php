<!DOCTYPE html>
<html>
<head>
    <title>Random Image</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
    (function($){
        $.randomImage = {
            defaults: {
                //you can change these defaults to your own preferences.
                path: 'img/', //change this to the path of your images
                myImages: ['pubmprofil.gif', 'pubnavette.gif'] //put image names in this bracket. ex: 'harold.jpg', 'maude.jpg', 'etc'
            }
        };
        
        $.fn.extend({
            randomImage:function(config) {
                var config = $.extend({}, $.randomImage.defaults, config);
                
                return this.each(function() {
                    var imageNames = config.myImages,
                    //get size of array, randomize a number from this
                    // use this number as the array index
                    imageNamesSize = imageNames.length,
                    lotteryNumber = Math.floor(Math.random()*imageNamesSize),
                    winnerImage = imageNames[lotteryNumber],
                    fullPath = config.path + winnerImage;
                    
                    //put this image into DOM at class of randomImage
                    // alt tag will be image filename.
                    $(this).attr({
                        src: fullPath,
                        alt: winnerImage
                    });
                });
            }
        });
    }(jQuery));
    
    $(document).ready(function(){
        $('img:first').randomImage();
    });
    </script>
</head>
<body>
    <img>
</body>
</html>