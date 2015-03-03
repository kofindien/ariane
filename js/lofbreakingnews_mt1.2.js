/**
 * The Breaking News plugin is a plugin to allow you add a flash - breaking news which  display 	
 * the article's title. With many animations supported and have an easy to control the module 
 * displaying via simple parameters, you can do everything as you like and let your client see 
 * headlines In a impression way
 * 
 
 * @version		$Id:  $Revision
 * @package		moo
 * @subpackage	mod_lofflashcontent
 * @copyright	Copyright (C) JAN 2010 LandOfCoder.com <@emai:landofcoder@gmail.com>. All rights reserved.
 * @website http://landofcoder.com/opensource/mootool/77-the-breakingnews-plug-in.html
 * @license		This plugin is dual-licensed under the GNU General Public License and the MIT License 
 */
if( typeof LofBreakingNews != Object ) {	
	var LofBreakingNews = new Class( {
		initialize:function( eMain, options ){ 	 
			this.setting = $extend({
				mainItemClass		: '.lof-breakingnew-item',
				wapperClass			: '.lof-breakingnews-wrapper',
				moduleTitleClass	: '.lof-module-nav',
				interval	  	 	: 3000,
				layoutStyle		    : 'hrleft',
				fxObject			: null,
				auto			    : true
			}, options || null  );
			//this.setOptions( options );
		//	this.setting = this.options;
			this.options=null;
			this.currentNo  = 0;
			this.nextNo     = null;
			this.previousNo = null;
			this.totalItems = 0;
			this.fxNavigatorImages=[];
			this.fxItems = [];
			this.minSize = 0;
			// 
			if( $defined(eMain) ){
				mTitleWidth =  (eMain.getElements(this.setting.moduleTitleClass)) !=''?parseInt(eMain.getElements(this.setting.moduleTitleClass).getStyle('width')):0;				
				this.slides = eMain.getElements( this.setting.mainItemClass );
				this.totalItems = this.slides.length;
				if( this.totalItems <= 1 ){
					return ;
				}
				var offset = 20;
				this.maxWidth  = this.slides[0].offsetWidth.toInt()-mTitleWidth-offset;
				this.maxHeight =  this.slides[0].offsetHeight.toInt();
				eMain.getElement( this.setting.wapperClass ).setStyle( 'width', Math.abs(this.maxWidth) );
				
				var fx =  $extend({waiting:false, onComplete:this.onComplete.bind(this)}, this.setting.fxObject );
				var styleMode = this.__getStyleMode(); 
				this.styleMode = styleMode;
			
				this.slides.each( function(item, index) { 
			   		this.fxItems[index] = new Fx.Tween( item, fx  );
					item.setStyles( eval('({'+styleMode[0]+': index * this.maxSize,"'+styleMode[1]+'":Math.abs(this.maxSize),"display" : "block"})') );			   
					// this.fxItems[index] = new Fx.Morph( item, fx );
				}.bind(this) );
				if( styleMode[0] == 'opacity' ){
					this.slides[0].setStyle(styleMode[0],'1');
				}
			}
		},
		__getStyleMode:function(){
			switch( this.setting.layoutStyle ){
				case 'opacity': this.maxSize=0; this.minSize=1; return ['opacity','opacity'];
				case 'vrup': this.maxSize=this.maxHeight; return ['top','height'];
				case 'vrdown':this.maxSize=-this.maxHeight;  return ['top','height'];
				case 'hrright': this.maxSize=-this.maxWidth; return ['left','width'];
				case 'hrleft':
				default: this.maxSize=this.maxWidth; return ['left','width'];
			}
		},
		registerButtonsControl:function( eventHandler, objects ){
			if( $defined(objects) && this.totalItems > 1 ){
				for( var action in objects ){
					if( $defined(this[action.toString()])  && $defined(objects[action]) ){
							objects[action].addEvent( eventHandler, this[action.toString()].bind(this, [true]) );
					}
				}
			}
			return this;	
		},
		start:function( isStart ){
			this.setting.auto = isStart;
			if( isStart ){this.play( this.setting.interval,'next', true );}
		},
		onComplete:function(){},	
		onProcessing:function( item, manual, start, end ){
		
			this.previousNo = this.currentNo + (this.currentNo>0 ? -1 : this.totalItems-1);
			this.nextNo 	= this.currentNo + (this.currentNo < this.totalItems-1 ? 1 : 1- this.totalItems);	
			if( manual ) { this.stop(); }
			return this;
		},
		finishFx:function( manual ){
			if( manual ) this.stop();
			if( manual && this.setting.auto )
				this.play( this.setting.interval,'next', true );
		},
		fxStart:function( index, start, end ){
		//	this.fxItems[index].start( eval("({'"+this.styleMode[0]+"':[start,end]})") );
			this.fxItems[index].cancel().start(this.styleMode[0], start, end);
			return this;
		},
		next:function( manual ){
			this.currentNo += (this.currentNo < this.totalItems-1) ? 1 : (1 - this.totalItems);	
			this.onProcessing( null, manual, 0, this.maxSize )
				.fxStart( this.currentNo, this.maxSize , this.minSize )
				.fxStart( this.previousNo, this.minSize,  -this.maxSize )
				.finishFx( manual );
		},
		previous:function( manual ){
			this.currentNo += this.currentNo > 0 ? -1 : this.totalItems - 1;
			this.onProcessing( null, manual, -this.maxWidth, this.minSize )
				.fxStart( this.nextNo, this.minSize, this.maxSize )
				.fxStart( this.currentNo, -this.maxSize, this.minSize )
				.finishFx( manual	);			
		},
		stop:function(){ $clear(this.isRun ); },
		play:function( delay, direction, wait ){
			this.stop(); 
			if(!wait){ this[direction](false); }
			this.isRun = this[direction].periodical(delay,this,false);
		}
	} );
}