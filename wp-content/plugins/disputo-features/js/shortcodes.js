(function() {
	tinymce.PluginManager.add('disputo_mce_button', function( editor, url ) {
		editor.addButton( 'disputo_mce_button', {
			text: 'Shortcodes',
			icon: false,
			type: 'menubutton',
					menu: [
                        {
							text: 'Button',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert a Button',
									body: [
                                        {
											type: 'textbox',
											name: 'buttonurl',
											label: 'URL:',
											value: ''
										},
                                        {
											type: 'textbox',
											name: 'buttontext',
											label: 'Button Text:',
											value: 'Click Here'
										},
                                        {
											type: 'listbox',
											name: 'newtab',
											label: 'Open in a new tab:',
											'values': [
												{text: 'No', value: ''},
												{text: 'Yes', value: 'yes'}
											]
										},
                                        {
											type: 'listbox',
											name: 'outline',
											label: 'Outline:',
											'values': [
												{text: 'No', value: ''},
												{text: 'Yes', value: 'yes'}
											]
										},
                                        {
											type: 'listbox',
											name: 'size',
											label: 'Size:',
											'values': [
												{text: 'Normal', value: ''},
												{text: 'Large', value: 'btn-lg'},
                                                {text: 'Small', value: 'btn-sm'}
											]
										},
                                        {
											type: 'listbox',
											name: 'style',
											label: 'Style:',
											'values': [
												{text: 'Primary', value: 'primary'},
												{text: 'Secondary', value: 'secondary'},
                                                {text: 'Success', value: 'success'},
                                                {text: 'Info', value: 'info'},
												{text: 'Warning', value: 'warning'},
                                                {text: 'Danger', value: 'danger'},
											]
										}
									],
									onsubmit: function( e ) {
										editor.insertContent( '[mpbutton url="' + e.data.buttonurl + '" newtab="'+ e.data.newtab +'" style="'+ e.data.style +'" outline="'+ e.data.outline +'" size="'+ e.data.size +'"]' + e.data.buttontext + '[/mpbutton]');
									}
								});
							}
						},
                        {
							text: 'Alert',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert an Alert',
									body: [
                                        {
											type: 'listbox',
											name: 'dismissible',
											label: 'Dismissible:',
											'values': [
												{text: 'No', value: ''},
												{text: 'Yes', value: 'dismissible'}
											]
										},
                                        {
											type: 'listbox',
											name: 'style',
											label: 'Style:',
											'values': [
                                                {text: 'Success', value: 'success'},
                                                {text: 'Info', value: 'info'},
												{text: 'Warning', value: 'warning'},
                                                {text: 'Danger', value: 'danger'},
											]
										},
                                        {
											type: 'textbox',
											name: 'text',
											label: 'Text:',
											value: ''
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[mpalert style="'+ e.data.style +'" dismissible="'+ e.data.dismissible +'"]' + e.data.text + '[/mpalert]');
									}
								});
							}
						},
                        {
							text: 'Progress',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Insert a progress bar',
									body: [
                                        {
											type: 'textbox',
											name: 'value',
											label: 'Value (A number between 0-100):',
											value: '50'
										},
                                        {
											type: 'listbox',
											name: 'style',
											label: 'Style:',
											'values': [
                                                {text: 'Success', value: 'success'},
                                                {text: 'Info', value: 'info'},
												{text: 'Warning', value: 'warning'},
                                                {text: 'Danger', value: 'danger'},
											]
										},
                                        {
											type: 'listbox',
											name: 'striped',
											label: 'Striped:',
											'values': [
												{text: 'No', value: ''},
												{text: 'Yes', value: 'yes'}
											]
										},
                                        {
											type: 'listbox',
											name: 'animated',
											label: 'Animated:',
											'values': [
												{text: 'No', value: ''},
												{text: 'Yes', value: 'yes'}
											]
										},
                                        {
											type: 'textbox',
											name: 'label',
											label: 'Label:',
											value: ''
										},
									],
									onsubmit: function( e ) {
                                        if(isNaN(e.data.value)) {
                                            editor.windowManager.alert('Value must be a number between 0 and 100.');
                                            return false;
                                        }
                                        else {
										  editor.insertContent( '[mprogress style="'+ e.data.style +'" striped="'+ e.data.striped +'" animated="'+ e.data.animated +'" value="'+ e.data.value +'" label="' + e.data.label + '"][/mprogress]');
                                        }
									}
								});
							}
						}
                    ]
		});
	});
})();