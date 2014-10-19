/*
 * Linkify jQuery Plugin v1.0.0
 *
 * Copyright (c) 2011 Dobot (http://dobot.github.com/)
 * Licensed under the MIT license.
 *
 */

(function($){
	$.extend({
		linkify: function(str, options) {
			var defaults = {
				link: {
					regex: /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig,
					template: "<a href=\"$1\">$1</a>"
				},
				user: {
					regex: /((?:^|[^a-zA-Z0-9_!#$%&*@＠]|RT:?))([@＠])([a-zA-Z0-9_]{1,20})(\/[a-zA-Z][a-zA-Z0-9_-]{0,24})?/g,
					template: '$1<a href="http://twitter.com/#!/$3$4">@$3$4</a>'
				},
				hash: {
					regex: /(^|\s)#(\w+)/g,
					template: '$1<a href="http://twitter.com/#!/search?q=%23$2">#$2</a>'
				},
				email: {
					regex: /([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi,
					template: '<a href=\"mailto:$1\">$1</a>'
				}
			};

			var types = $.extend(defaults, options);

			$.each(types, function(name, type) {
				str = str.replace(type.regex, type.template);
			});

			return str;
		}
	});
})(jQuery);

BUNMUN =
{
	pageLoad: function(){
		//BUNMUN.getLatestTweet();
		//BUNMUN.parseBlogRSS("http://feeds.feedburner.com/selectb", "WordPress", 3);
		//BUNMUN.parseBlogRSS("http://bunmblr.selectb.com/rss", "Tumblr", 3);  
		BUNMUN.TwitterLinks();
		BUNMUN.RoleDescriptions();
	},
	
	
	RoleDescriptions: function(){
	
	
		//Preload Images
		var roleImages = new Array();
		var count = 0;
		$(".role-button").each(function(){
			
			var imgName = $(this).attr("data-image");
			var roleImage = new Image();
			roleImage.src = "images/"+imgName;
			roleImages.push(roleImage);
			
			//add data number
			$(this).attr("data-number", count);
			count++;
		});
		
		
		
		
		
		var listHeight = $(".buttonList").height();
		var listPositionTop = $(".role-button:first-child").position().top;
			console.log("Height of list: "+listHeight);
			console.log("List Position: "+listPositionTop);
		
		$(".role-button").click(function(e){
			e.preventDefault();
			if($(this).is(":not(.selected)")){
			
			//alert("Not Selected");
			
			//Get the role
			var role = $(this).attr("data-role");
			
			//Hide current role description
			$(".role-descriptions .description").slideUp();
			$(".description[data-role='"+role+"']").slideDown();
			
			//Remove and Add selected class
			$(".role-button.selected").removeClass("selected");
			$(this).addClass("selected");
			
			//Set background image
			var roleNum = $(this).attr("data-number");
			var roleImageSrc = roleImages[roleNum].src;
			var imgSize = $(this).attr("data-image-size");
			var imgPos = $(this).attr("data-image-pos");
			
			//$("#Intro").animate({opacity: 0}, 1000);
			
			$("#Intro").css({
				backgroundImage: "url("+roleImageSrc+")",
				backgroundOrigin: "content-box",
				backgroundSize: imgSize,
				backgroundRepeat: "no-repeat",
				backgroundPosition: imgPos
			});
			
			var target = $("#Intro");
			
			$('html,body').animate({
				scrollTop: target.offset().top
			}, 500);
			
			//Get top position of current role
			var rolePositionTop = $(this).position().top;
			console.log("Role Position Top: "+rolePositionTop);
			var relativePos = listPositionTop - rolePositionTop;
			
			console.log("relativePos: "+relativePos);
			
			//Reposition the top of the buttonList
			$(".buttonList").css({
				'top': relativePos
			});
			
			$(".role-button:not(.selected)").css("visibility", "hidden");

			}
			else{
				
				//alert("This is selected!");
				var visibleCount = $('.role-button').filter(function() {
										return $(this).css('visibility') !== 'hidden';
									}).length;
				
				console.log("Visible Count: "+visibleCount);
				
				//If other roles are visible, then hide them
				
				if(visibleCount > 1){
					$(".role-button:not(.selected)").css("visibility", "hidden");
				}
				else{ $(".role-button").css("visibility", "visible"); }
				
			} //END IF VISIBLE
		});
		
		
		$(".expand").toggle(function(){
			
			$(".role-button").css("visibility", "visible");
			
		}, function(){
			
			$(".role-button:not(.selected)").css("visibility", "hidden");
			
		});
		
	},
	
	tallestChild: function(parentContainer){
		
		var tallestHeight = 0;
		$(parentContainer).children().each(function(){
			
			var thisHeight = $(this).height();
			
			if(thisHeight > tallestHeight) tallestHeight = thisHeight;
			
		});
		
		return tallestHeight;
		
	},
	
	equalHeights: function(parentContainer){
		
		var setHeight = BUNMUN.tallestChild(parentContainer);
		
		$(parentContainer).children().each(function(){
			
			$(this).height(setHeight);
			
		});
		
	},
	
	getLatestTweet: function(){
		//var count = 0;
		$.getJSON("../Bunmun_Foundation/php/TwitterSettingsEcho.php", function(data) {
		
			$.each(data, function(i){
				var linkified = $.linkify(data[i].text)
				var postTemplate = "<li><p>"+linkified+"</p><time datetime='"+data[i].created_at+"'>"+BUNMUN.TwitterDateConverter(data[i].created_at)+"</time><span><a class='tweet_reply' title='Reply' href='https://twitter.com/intent/tweet?in_reply_to="+data[i].id_str+"'>Reply</a><a class='tweet_retweet' title='Retweet' href='https://twitter.com/intent/retweet?tweet_id="+data[i].id_str+"'>Retweet</a><a class='tweet_fave' title='Favorite' href='https://twitter.com/intent/favorite?tweet_id="+data[i].id_str+"'>Favorite</a></span></li>";
			
			$("#Twitter .posts").append(postTemplate);
				
			});
			
			BUNMUN.equalHeights('#Social .row');
		});
	},
	
	TwitterLinks: function(){
			
			//Grab all Tweets
			$(".tweetContent p").each(function(){
				
				var linkedTweet = $.linkify($(this).text());
				$(this).html(linkedTweet);
				
			});
	},
	
	TwitterDateConverter: function(time){
	var date = new Date(time),
		diff = (((new Date()).getTime() - date.getTime()) / 1000),
		day_diff = Math.floor(diff / 86400);
 
	if ( isNaN(day_diff) || day_diff < 0 || day_diff >= 31 )
		return;
 
	return day_diff == 0 && (
			diff < 60 && "just now" ||
			diff < 120 && "1 minute ago" ||
			diff < 3600 && Math.floor( diff / 60 ) + " minutes ago" ||
			diff < 7200 && "1 hour ago" ||
			diff < 86400 && Math.floor( diff / 3600 ) + " hours ago") ||
		day_diff == 1 && "Yesterday" ||
		day_diff < 7 && day_diff + " days ago" ||
		day_diff < 31 && Math.ceil( day_diff / 7 ) + " weeks ago";
	},
	
	parseBlogRSS: function(url, containerID, count){
	
		var tumblr = false;
		
		if(containerID === "Tumblr") tumblr = true;
	
		
	
		$.jGFeed(url, function(feeds){
			
			//Insert blog title into an H2
			$("#"+containerID+" h2.blogTitle").html(feeds.title);
			
			var postTemplate = "";
			for(var i=0; i<count; i++){
		     var pubDate = new Date(feeds.entries[i].publishedDate);
			 postTemplate ='<li class="post"><a class="block" href="'+feeds.entries[i].link+'" target="_blank"><time datetime="'+feeds.entries[i].publishedDate+'">'+pubDate.getMonth()+'.'+pubDate.getDate()+'.'+pubDate.getFullYear()+'</time><h6>'+feeds.entries[i].title+'</h6>';
			 
			 if(tumblr){
				postTemplate += feeds.entries[i].content; 
			 }
			 else { postTemplate += "</a></li>";}
			 
			 $("#"+containerID+" .posts").append(postTemplate);
			 if(tumblr){ 
			 
			 	//Add class to images
			 	$("#"+containerID+" .posts .block img").addClass("tumblrImg");
			 	
			 	
			 	//Remove image from list
			 	$(".tumblrImg").each(function(){
				 	var imgSrc = $(this).attr("src");
				 	$(this).closest(".post").css("background", "url("+imgSrc+") no-repeat 50% 50%");
				 	$(this).remove();
			 	});
			 	
			 	//Remove paragraphs
			 	$("#"+containerID+" .posts .block p").remove();			 	
			 }
			 
			}
			
		});	
		
	},
	
};


