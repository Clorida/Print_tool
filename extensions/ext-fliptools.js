/*
 * ext-fliptools.js
 *
 * Extension to add toolbar buttons for flipping an object either vertically or horizontally.
 * 
 * Written by Senthil Mummachi
 */
 
svgEditor.addExtension("Flip tools", function() {
		var svgroot = svgCanvas.getRootElem();
		var selElems,
		showPanel = function(on) {
			$('#fliptool_panel').toggle(on);
		};
		var batchCmd;
		function flipElement (type)
		{
			var i = selElems.length;
			batchCmd = new svgCanvas.undoCmd.batch('Flip ' + (type == '-' ? 'horizontal' : 'vertical'));
			// go thru each element selected and flip
			while (i--) {
				var elem = selElems[i];
				if (elem) {
					var box = elem.getBBox();
					var x = box.x, y = box.y;
					var scale;   
					if (type == "-"){ // if the flip type is horizontal
						scale = "scale(-1,1)";
						x += (box.width / 2);
					} 
					else { // if the flip type is vertical
						scale = "scale(1,-1)";
						y += (box.height / 2);
					}
					// check if the element got any transform attrib set, so we can use it later
					var attrib = elem.getAttribute('transform');
					if (attrib)
						batchCmd.addSubCommand(new svgCanvas.undoCmd.changeElement(elem, {transform: attrib}));
						
					// set the transformation to do the flipping
					elem.setAttribute('transform', "translate(" + x + "," + y + ") " + scale + " translate(" + -x + "," + -y + ")");
					
					// recalculate the dimensions so that it removes 'transform' attribute
					batchCmd.addSubCommand(svgCanvas.recalculateDimensions(elem));
						
					// if there is a rotation present, change the angle of rotation (set to a -ve value if it was +ve and vice versa) to give the mirror reflection effect
					if (attrib){
						// rotation is set in the following format: rotate(-26.8698, 158, 369.5)
						var re = /rotate\(([-+]?\d*(?:\.\d+)?)\,\s*([-+]?\d*(?:\.\d+)?)\,\s*([-+]?\d*(?:\.\d+)?)\)/i;
						var m = attrib.match(re);
						// re-write the transform attribute by changing only the rotation and preserve other transformation info    
						if (m){
							var rotation = 'rotate(' + (0 - parseFloat(m[1])) + ', ' + m[2] + ', ' + m[3] + ')';
							elem.setAttribute('transform', attrib.replace(re, rotation)); 
						}
						else // we don't know how other transformation would get impacted yet, so we simply set them back
							elem.setAttribute('transform', attrib);
						batchCmd.addSubCommand(new svgCanvas.undoCmd.changeElement(elem, {transform: elem.getAttribute('transform')}));
					}
					// check if the element has graidents set for stroke or fill, if so flip the graidents as well
					flipGradients(elem, type);
				}
			}
			// add to undo history
			if (!batchCmd.isEmpty())
				svgCanvas.undoCmd.add(batchCmd);
			
			// once all the elements are flipped, clear selection because the selection handles might be staying on the original location 
			svgCanvas.clearSelection();
			
			//**TODO: make the flipped object selected. It doesn't look straight forward as it sounds since, the previous step nullifies the elements
			//svgCanvas.addToSelection(selElems, true);
		}
		
		function flipAttrib(grad, attr1, attr2)
		{
			if (attr2){ //linearGraident : switch x1 and x2 or y1 and y2 values
				var val1 = grad.attr(attr1);
				var val2 = grad.attr(attr2);
				if (val1 != null && val2 != null){ //we explicitly check for null here, since doing 'if (val)' may return false when the value is 0
					var changes = grad.attr([attr1, attr2]);
					grad.attr(attr1, val2);
					grad.attr(attr2, val1);
					// add to undo history
					if (batchCmd != null)
						batchCmd.addSubCommand(new svgCanvas.undoCmd.changeElement(grad[0], changes));
				}
			}
			else { //radialGradient: alternate the x or y value. If the value is 0 set it to 1, if it is 1 set it to 0 
				var val = grad.attr(attr1); // get the x value
				if (val != null) //we explicitly check for null here, since doing if (val) may return false when the value is 0
				{
					var changes = grad.attr([attr1]);
					grad.attr(attr1, 1 - val);
					if (batchCmd != null)
						batchCmd.addSubCommand(new svgCanvas.undoCmd.changeElement(grad[0], changes));
				}
			}
		}
		
		function flipGradients (elem, type){
			flipGraident(elem, 'stroke', type);
			flipGraident(elem, 'fill', type);
			// look in to all child elements if they have gradients
			$.each(elem.childNodes, function(i, child) {
				flipGradients(child, type);
			});			
		}
		function flipGraident(elem, brushType /* stroke or fill */, flipType)
		{
			var attr = $(elem).attr(brushType);
			if (attr){
				var id = svgCanvas.getUrlFromAttr(attr);
				if (id)
				{
					var grad = $(svgroot).find('[id=' + id.substring(1) + ']');
					if (grad.length > 0){
						if (grad[0].tagName.indexOf('linearGradient') >= 0){
							if (flipType == '-') //horizontal: flip x1 & x2 values
								flipAttrib(grad, 'x1', 'x2');
							else  //vertical: flip y1 & y2 values
								flipAttrib(grad, 'y1', 'y2');
						}
						else if (grad[0].tagName.indexOf('radialGradient') >= 0) { //radialgradient
							if (flipType == '-'){ //horizontal: switch the value of x between 0 and 1
								flipAttrib(grad, 'cx', null);
								flipAttrib(grad, 'fx', null);
							}
							else { //vertical : switch the value of y between 0 and 1
								flipAttrib(grad, 'cy', null);
								flipAttrib(grad, 'fy', null);
							}
						}
					}
				} 
			}
				
		}
		return {
			name: "Flip tools",
			svgicons: "extensions/ext-fliptools-icon.xml",
			buttons: [{
				id: "tool_flipHoriz",
				type: "context",
				panel: "fliptool_panel",
				title: "Flip Horizontal",
				events: {
					'click': function() {
						//$.alert('Flip Horizontal');
						flipElement('-');
					}
				}
			},{
				id: "tool_flipVert",
				type: "context",
				panel: "fliptool_panel",
				title: "Flip Vertical",
				events: {
					'click': function() {
						flipElement('|');
					}
				}
			}],
			
			selectedChanged: function(opts) 
			{
				var currentMode = svgCanvas.getMode();
				selElems = opts.elems;
				if ((opts.multiselected || opts.selectedElement) && currentMode != 'pathedit')
					showPanel(true);
				else
					showPanel(false);
			}
		};
});

