<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row">
    <div class=" {{ (isset($wide) && $wide == true? 'col-md-12': 'col-md-offset-1 col-md-10') }}">
        <ul class="ld-breadcrumb sdg_flex _flex_v_center">
            <li class="sdg_stretch"><a href="/dash"><span class="bread-home"></span></a><i class="fa fa-angle-right"></i></li>
            <li class="sdg_stretch"><p><a>{{ $bc }}</a></p></li>
        </ul>
        <hr class="bread-rule">
        <span> &copy; {{ date('Y') }} Lake Doctors Inc. All rights reserved.</span>
        <span class="pull-right"> <a href="mailto:support@santodesigngroup.com">Support</a></span>
    </div>
</div>