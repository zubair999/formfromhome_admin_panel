	$(document).ready(function(){
		const baseUrl = location.origin + '/';



		function addLoader(){
			$('body').css('overflow','hidden');
			$('.showLoader').css('display','flex');
		}

		function removeLoader(){
			$('body').css('overflow','unset');
			$('.showLoader').css('display','none');
		}

		function addGifLoader() {
	        $('#gifLoader').css({display: 'flex'});
	        $('body').css('overflow','hidden');
	    }

	    function removeGifLoader() {
	        $('#gifLoader').css("display", "none");
	    }

		function smallLoader(){
			return `
				<div style="height:100%;background:#fff;display:flex;justify-content:center;align-items:center">
					<svg width="50px" height="50px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						<circle cx="50" cy="50" fill="none" stroke="#1d7673" stroke-width="13" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" transform="rotate(265.955 50 50)">
						  <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1.36986301369863s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
						</circle>
					</svg>
				</div>
			`;
		}


		function loginForm(){
			return `
		                <div class="form-group">
		                  <input type="file" name="phone" class="form-control" aria-describedby="log">
		                  <small id="loginPhoneErr" class="form-text text-muted"></small>
		                </div>


		                <div class="row">
		                  	<div class="col-lg-2">
		                  		<input type="button" class="btn btn-primary" id="selectStudentPhoto" value="Select Image">                      
		                  	</div>

		                  <div class="col-lg-2 mt-1" id="login_sts">
		                  </div>
		                </div>
	                
	              `;
		}

		

		function showModal(component,modalTitle){
			const modal =`
				<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
			      <div class="modal-dialog" role="document">
			        <div class="modal-content" style="height:500px">
			          <div class="modal-header" style="display: flex;
					  justify-content: space-around;
					  align-items: center;">
			            <h5 class="modal-title">${modalTitle}</h5>
			            <a class="btn btn-secondary" id="closeModal">Close</a>
			          </div>
			          <div class="modal-body" style="height:400px">

			            <div class="">
			                   ${component}
			            </div>

			          </div>
			          <div class="modal-footer">

			            
			          </div>
			        </div>
			      </div>
			    </div>
			`;

			$('#appRoot').html(modal);
			$("html").css('overflow','hidden');
			$('#appRoot').addClass('modalOverlay');
			$('#loginModal').addClass('show');
			$('#loginModal').removeClass('fade');
			$('#loginModal').css('display', 'block');
		}

		document.addEventListener('click', function(e){
			if(e.target.attributes.id.value == 'closeModal'){
				document.getElementById('appRoot').classList.remove('modalOverlay');
				document.getElementById('appRoot').innerHTML = '';
				document.documentElement.style.overflow = 'scroll';
			}
		});

		const changeStudentPhoto = document.querySelectorAll('.changeImg');
		for(let i = 0; i < changeStudentPhoto.length; i++) {
			changeStudentPhoto[i].addEventListener('click', function(e){
				if(e.target.nextSibling.attributes){
					e.target.nextSibling.remove();
				}
				else{
					e.target.insertAdjacentHTML('afterend', `<input type="file" name="${e.target.attributes.for.value}" required>`);
				}
			});
		}

		
		
		const deleteDoc = document.querySelectorAll('.deleteDoc');
		for (let i = 0; i < deleteDoc.length ; i++) {
			deleteDoc[i].addEventListener('click', function(e){
				let marksheetId = e.target.getAttribute('data-marksheet');
				$.ajax({
					url:baseUrl + 'delete-marksheet',
					method:'post',
					data:{
						marksheetId:marksheetId
					},
					dataType:'json',
					beforeSend:function(){
						addGifLoader();
					},
					success:function(res){
						console.log(res);
						removeGifLoader();
						e.target.parentElement.parentElement.parentElement.parentElement.remove();
					},
					error:function(res){
						console.log(res);
					}
				});

			});
		}

		document.querySelectorAll('.dcerti').forEach(certificate => {
		  certificate.addEventListener('click', e => {
		    if(e.target.hasAttribute('data-certificate')){
		    	let certificateId = e.target.getAttribute('data-certificate');
		    	if(certificateId != '' && certificateId != null && certificateId != undefined){
		    		$.ajax({
			    		url:baseUrl + 'delete-certificate',
			    		method:'post',
			    		dataType:'json',
			    		data:{
			    			certificateId:certificateId
			    		},
			    		beforeSend:function(){
			    			addGifLoader();
			    		},
			    		success:function(res){
			    			removeGifLoader();
			    			e.target.parentElement.parentElement.parentElement.parentElement.remove();
			    		},
			    		error:function(res){
			    			console.log(res);
			    		}
		    		});
		    	}
		    	else{
		    		console.log("empty string");
		    	}
		    }
		  })
		})
		

		document.addEventListener('click', function(e){
			

		  	if(e.target.hasAttribute('data-stuinfo')){
		  		let studentId = e.target.getAttribute('data-stuinfo');
		  		$.ajax({
			        url:baseUrl+'student-info',
			        dataType:'json',
			        method:'post',
			        data:{
			          stu_id:studentId
			        },
			        beforeSend:function(){
			        	addGifLoader();
			        },
			        success:function(res){
			        	removeGifLoader();
			        	console.log(res);
			        	const profile = getProfile(res.info,res.document);
			        	const certificate = getCertificate(res.certificate);
			        	const academic = getAcademic(res.academic);

			        	const studentInformation = `<div style="overflow:hidden scroll;height:400px">
			        									${profile}
														${academic}
														${certificate}
			        								</div>`;


			        	showModal(studentInformation,'Student Information');
			        	document.querySelector('.modal-dialog').style.width = '900px';
			        },
			        error:function(res){
			        	console.log(res);
			        }
				 });
		  	}
		});


		function studentDocument(studentDocs){

			studentDoc = [];
			studentDocs.forEach(function(doc){
				studentDoc += `
						<div class="col-md-2" style="margin-bottom:24px;" align="center">
						    <img src="${baseUrl}${doc}" title="Student Signature">
						     <br>
						    <input checked type="checkbox" name="images[]" class="select" value="${doc}">
						</div>
				`
			});

			return `
				<form method="post" action="${baseUrl}download-zip-file">
				   ${studentDoc}
				  <div align="center">
				   <input type="submit" name="download" class="btn btn-primary" value="Download All Document">
				  </div>
				</form>
			`;
		}


		function getProfile(si,studentDocs){
			const studentDoc = studentDocument(studentDocs);
			return `
	              <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
	              <table class="table table-bordered stu-info-01 tblt-se-01">
	                    <tr>
	                      <th colspan="3" class="stu_021 text-capitalize text-center" style="font-size:30px;">personal information</th>
	                    </tr>

						<tr>
	                      <td class="stu_021 text-capitalize set-011">
	                        ${studentDoc}
						  </td>
	                  	</tr>


						<tr>
	                      <th class="stu_021 text-capitalize">Adhar No</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText1">${si.adhar_no}<div></td>
	                      <td><button class="copyText" id="copytextBtn1"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
						<tr>
	                      <th class="stu_021 text-capitalize">Mobile No</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText1">${si.mobile}<div></td>
	                      <td><button class="copyText" id="copytextBtn1"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">student name</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText1">${si.student_name.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn1"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">father name</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText12">${si.father_name.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn12"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">mother name</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText13">${si.mother_name.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn13"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">date of birth</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText2">${si.dob}<div></td>
	                      <td><button class="copyText" id="copytextBtn2"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">email</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText3">${si.user_name.toLowerCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn3"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">category</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText4">${si.category_name.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn4"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">house no</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText5">${si.house.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn5"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">block</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText6">${si.block.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn6"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">district</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText7">${si.district.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn7"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">state</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText8">${si.state_name.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn8"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">pincode</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText9">${si.pincode}<div></td>
	                      <td><button class="copyText" id="copytextBtn9"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>

	                    </tr>
	                    <tr>
	                      <th class="stu_021 text-capitalize">full address</th>
	                      <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText11">${si.address.toUpperCase()}<div></td>
	                      <td><button class="copyText" id="copytextBtn11"><img class="clippy" src="https://clipboardjs.com/assets/images/clippy.svg" alt="Copy to clipboard" width="13"></button></td>
	                    </tr>
	                    
	              </table>
	              </div>
	              `;
		}

		function getAcademic(ac){

			var a_info = [];
	        ac.forEach(function(ac){
	            a_info += `
	            			
		              	<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
		              	<table class="table table-bordered stu-info-01 tblt-se-01">
							<tbody>
				                <tr>
				                  <th colspan="3" class="text-center text-capitalize" style="font-size:30px;">${ac.qualification_name}</th>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">passing year</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText14">${ac.passing_year}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">board</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText15">${ac.board_name.toUpperCase()}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">total marks</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText16">${ac.total_marks}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">obtained marks</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText17">${ac.marks_obtained}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">percentage</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText18">${ac.percentage}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">mediam</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText19">${ac.mediam_name.toUpperCase()}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">stream</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText20">${ac.stream_name.toUpperCase()}</div></td>
				                </tr>
				                <tr>
				                  <th class="stu_021 text-capitalize">extra info</th>
				                  <td class="stu_021 text-capitalize"><div class="ieOp4_f" id="copyText21">${ac.extra_info.toUpperCase()}</div></td>
				                </tr>
				              </tbody>

				              </table>
	              			</div>
						`;
			});


	       


			return a_info;
		}

		function getCertificate(certificate){
			if(certificate){
				var cer_t = [];
	            certificate.forEach(function(c){
	            cer_t += `
					                <tr>
					                  <th class="stu_021 text-capitalize">${c.certificate_name}</th>
					                </tr>
							`
	                    ;
	          });

	            const studentCertificateList = `

					<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
						<table class="table table-bordered stu-info-01 tblt-se-01">
							<tbody>
				                <tr>
				                  <th colspan="3" class="text-center text-capitalize" style="font-size:30px;">Certificates</th>
				                </tr>
								${cer_t}
				        	</tbody>
				       	</table>
	              	</div>
	            `;

	          return studentCertificateList;
			}
			else{
				return `<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
						    <table class="table table-bordered stu-info-01 tblt-se-01">
								<tbody>
					                <tr>
					                  <th colspan="3" class="text-center text-capitalize" style="font-size:30px;">Certificates</th>
					                </tr>
					                <tr>
					                  <th class="stu_021 text-capitalize">No certificate uploaded yet!</th>
					                </tr>
					            </tbody>
				            </table>
	              		</div>`;
			}
		}



		document.addEventListener('click', function(e){
			const studentUser = e.target.getAttribute('data-studentUser');
			if(e.target.attributes.id.value == 'downloadDocs'){
				$.ajax({
					url:baseUrl + `get-zip/${studentUser}`,
					method:'post',
					contentType: 'application/zip',
					xhrFields: {
			            responseType: 'blob'
			        },
					beforeSend:function(){
						addGifLoader();
					},
					success:function(res){
						removeGifLoader();
						downloadZipFile(res);
					},
					error:function(res){
						console.log(res);
						removeGifLoader();
					}
				});
			}
		});

		function downloadZipFile(zipContent){
	        var a = document.createElement('a');
	        var url = window.URL.createObjectURL(zipContent);
	        a.href = url;
	        a.download = 'studentFile.zip';
	        document.body.append(a);
	        a.click();
	        a.remove();
	        window.URL.revokeObjectURL(url);
	    }

		// JQUERY ENDS
	});


