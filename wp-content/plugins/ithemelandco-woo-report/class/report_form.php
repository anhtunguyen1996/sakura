<?php
echo '
<div class="awr-news-header">
	<div class="awr-news-header-big">'. esc_html__("Request Form",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'</div>
	<div class="awr-news-header-mini">'. esc_html__("Send your request / issue for us",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'</div>
</div>
<div class="awr-request-form">

   <form action="" class="it_request_form">
	    <div class="row">
	        <div class="col-md-12">
				<span class="awr-form-icon"><i class="fa fa-user"></i></span>
	            <input name="awr_fullname" id="awr_fullname" type="text" placeholder="'. esc_html__("Enter Full Name..",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'" >
	        </div>

	        <div class="col-md-12">
				<span class="awr-form-icon"><i class="fa fa-envelope-o"></i></span>
	            <input name="awr_email" id="awr_email" type="text" placeholder="'. esc_html__("Enter Email.",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'" value="'.get_option("admin_email").'">
	        </div>

	        <div class="col-md-12">
				<span class="awr-form-icon"><i class="fa fa-check"></i></span>
	            <select name="awr_subject" class="">
	                <option value="">'. esc_html__("Select Subject",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .' </option>
	                <option value="request">'. esc_html__("Send a Request",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'</option>
	                <option value="issue">'. esc_html__("Report an issue",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'</option>
				</select>
	        </div>

	        <div class="col-md-12">
				<span class="awr-form-icon"><i class="fa fa-font"></i></span>
	            <input name="awr_title" id="awr_title" type="text" placeholder="'. esc_html__("Enter Title.",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'" >
	        </div>

	        <div class="col-md-12">
	            <textarea name="awr_content" id="awr_content" placeholder="'. esc_html__("Enter Your request / issue...",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'"></textarea>
	        </div>

	        <div class="col-md-12">
				<div class="fetch_form_loading fetch_form_loading_request search-form-loading"></div>
	            <button type="submit" value="Search" class="button-primary it_request_form_submit"><i class="fa fa-reply"></i> <span>'. esc_html__("Send",__IT_REPORT_WCREPORT_TEXTDOMAIN__) .'</span></button>
	        </div>
	        <div class="col-md-12 it_request_form_message">

			</div>
	    </div>
   </form>

</div>';
?>
