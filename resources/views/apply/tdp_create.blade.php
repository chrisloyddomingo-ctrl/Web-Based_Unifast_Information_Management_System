<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniFAST-TDP Application Form</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <style>
        body{
            margin:0;
            background:#e5e5e5;
            font-family: Arial, Helvetica, sans-serif;
            color:#000;
        }

        .page-actions{
            width:980px;
            max-width:calc(100% - 20px);
            margin:16px auto 8px;
            display:flex;
            justify-content:space-between;
            gap:10px;
        }

        .paper{
            width:980px;
            max-width:calc(100% - 20px);
            margin:0 auto 24px;
            background:#fff;
            border:1px solid #bdbdbd;
            box-shadow:0 3px 12px rgba(0,0,0,.08);
            padding:8px 10px 12px;
        }

        table.main-form{
            width:100%;
            border-collapse:collapse;
            table-layout:fixed;
            font-size:10px;
            line-height:1.05;
        }

        table.main-form td{
            border:1px solid #000;
            padding:2px 4px;
            vertical-align:middle;
            word-wrap:break-word;
        }

        .no-border{
            border:none !important;
        }

        .center{
            text-align:center;
        }

        .right{
            text-align:right;
        }

        .top{
            vertical-align:top !important;
        }

        .middle{
            vertical-align:middle !important;
        }

        .label{
            font-weight:700;
        }

        .tiny{
            font-size:8px;
            line-height:1.0;
        }

        .mini{
            font-size:7px;
            line-height:1.0;
        }

        .header-logo{
            text-align:center;
            padding:0 !important;
        }

        .header-logo img{
            width:52px;
            height:52px;
            object-fit:contain;
            display:block;
            margin:0 auto;
        }

        .header-text{
            text-align:center;
            line-height:1.05;
            padding-top:0 !important;
            padding-bottom:2px !important;
        }

        .header-text .rp{
            font-size:9px;
        }

        .header-text .sys{
            font-size:11px;
            font-weight:700;
        }

        .header-text .addr{
            font-size:7px;
        }

        .title-1,
        .title-2,
        .title-3{
            margin:0;
            text-align:center;
            line-height:1.08;
            text-transform:uppercase;
        }

        .title-1{
            font-size:12px;
            font-weight:700;
            font-style:italic;
        }

        .title-2{
            font-size:14px;
            font-weight:700;
        }

        .title-3{
            font-size:12px;
            font-weight:700;
            margin-bottom:2px;
        }

        .id-box{
            height:92px;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            font-size:9px;
            line-height:1.1;
            font-weight:700;
        }

        .instructions{
            font-size:8px;
            line-height:1.05;
            padding-top:1px !important;
            padding-bottom:3px !important;
        }

        .section-title{
            text-align:center;
            font-weight:700;
            text-transform:uppercase;
            font-size:10px;
            letter-spacing:.2px;
        }

        .line-input,
        .line-textarea{
            width:100%;
            border:none;
            outline:none;
            background:transparent;
            padding:0;
            margin:0;
            box-shadow:none;
            font-size:10px;
            line-height:1.05;
        }

        .line-textarea{
            resize:none;
            overflow:hidden;
            min-height:18px;
        }

        .line-center{
            text-align:center;
        }

        .cell-label-top{
            display:block;
            text-align:center;
            font-size:8px;
            line-height:1.0;
            margin-top:1px;
        }

        .checks-vertical{
            display:flex;
            flex-direction:column;
            gap:1px;
            align-items:flex-start;
            padding-left:10px;
        }

        .checks-horizontal{
            display:flex;
            gap:8px;
            align-items:center;
            flex-wrap:wrap;
        }

        .checks-horizontal label,
        .checks-vertical label{
            display:inline-flex;
            align-items:center;
            gap:2px;
            white-space:nowrap;
            font-size:10px;
        }

        .signature-line{
            width:100%;
            border:none;
            border-bottom:1px solid #000;
            outline:none;
            background:transparent;
            padding:0;
            margin:0 0 2px 0;
            text-align:center;
            font-size:10px;
        }

        .sign-note{
            text-align:center;
            font-size:8px;
            line-height:1.0;
        }

        .note-center{
            text-align:center;
            font-size:8px;
            line-height:1.0;
        }

        .do-not-fill{
            text-align:center;
            font-weight:700;
            text-transform:uppercase;
            font-size:10px;
        }

        .req-cell{
            vertical-align:top !important;
            min-height:120px;
        }

        .bottom-actions{
            margin-top:10px;
            display:flex;
            justify-content:flex-end;
            gap:8px;
        }

        @media print{
            body{
                background:#fff;
            }

            .page-actions,
            .bottom-actions{
                display:none !important;
            }

            .paper{
                width:100%;
                max-width:100%;
                margin:0;
                padding:0;
                border:none;
                box-shadow:none;
            }

            @page{
                size:A4 portrait;
                margin:7mm;
            }
        }

        @media (max-width:768px){
            .paper{
                padding:6px;
            }

            table.main-form,
            .line-input,
            .line-textarea,
            .signature-line{
                font-size:9px;
            }

            .header-logo img{
                width:40px;
                height:40px;
            }

            .id-box{
                height:70px;
                font-size:8px;
            }
        }
    </style>
</head>
<body>

<div class="page-actions">
    <a href="{{ route('apply.options') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
    <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Print Preview</button>
</div>

<div class="paper">
    <form method="POST" action="#" enctype="multipart/form-data">
        @csrf

        <table class="main-form">
            <colgroup>
                <col style="width:10%;">
                <col style="width:16%;">
                <col style="width:16%;">
                <col style="width:16%;">
                <col style="width:14%;">
                <col style="width:14%;">
                <col style="width:14%;">
            </colgroup>

            {{-- HEADER --}}
            <tr>
                <td class="header-logo no-border">
                    <img src="{{ asset('assets/img/unifastLogoclear.png') }}" alt="UniFAST Logo">
                </td>
                <td colspan="5" class="header-text no-border">
                    <div class="rp">Republic of the Philippines</div>
                    <div class="sys">Unified Student Financial Assistance System for Tertiary Education</div>
                    <div class="addr">Ground Floor Bldg. 6, UP Ayala Land Technohub Complex, Commonwealth Ave., Diliman, Quezon City</div>
                    <div class="addr">Email: unifastregioncar@ched.gov.ph</div>
                </td>
                <td class="header-logo no-border">
                    <img src="{{ asset('assets/img/ifsu.png') }}" alt="IFSU Logo">
                </td>
            </tr>

            <tr>
                <td colspan="6" class="no-border center" style="padding-top:0; padding-bottom:2px;">
                    <p class="title-1">CHED Regional Office CAR</p>
                    <p class="title-2">UniFAST Tulong Dunong Program (UniFAST-TDP)</p>
                    <p class="title-3">Application Form</p>
                </td>
                <td rowspan="3" class="id-box top">
                    2x2 ID PICTURE<br>
                    <span class="tiny">(Insert Photo Here)</span><br><br>
                    <input type="file" name="id_picture" class="line-input" style="font-size:8px;">
                </td>
            </tr>

            <tr>
                <td colspan="6" class="instructions no-border">
                    <strong>Instructions:</strong> Read General and Documentary Requirements. Fill in all the required information.
                    Do not leave an item blank. If item is not applicable, write N/A.
                </td>
            </tr>

            <tr>
                <td colspan="6" class="section-title">PERSONAL INFORMATION</td>
            </tr>

            {{-- NAME / ZIP --}}
            <tr>
                <td rowspan="2" class="label">Name</td>
                <td class="center">
                    <input type="text" name="last_name" class="line-input line-center">
                    <span class="cell-label-top">(Last Name)</span>
                </td>
                <td class="center">
                    <input type="text" name="first_name" class="line-input line-center">
                    <span class="cell-label-top">(First Name)</span>
                </td>
                <td class="center">
                    <input type="text" name="middle_name" class="line-input line-center">
                    <span class="cell-label-top">(Middle Name)</span>
                </td>
                <td colspan="2" class="center">
                    <div>Maiden Name</div>
                    <span class="cell-label-top">(for Married Women)</span>
                </td>
                <td class="center">
                    <div>Zip Code</div>
                </td>
            </tr>

            <tr>
                <td class="label top">
                    Date of Birth<br>
                    <span class="tiny">(mm/dd/yyyy)</span>
                </td>
                <td colspan="2">
                    <input type="text" name="birthdate" class="line-input">
                </td>
                <td class="label center">Permanent Address</td>
                <td colspan="2">
                    <input type="text" name="permanent_address" class="line-input">
                </td>
            </tr>

            {{-- PLACE OF BIRTH / SUB ADDRESS / ZIP VALUE --}}
            <tr>
                <td class="label">Place of Birth</td>
                <td colspan="2">
                    <input type="text" name="birth_place" class="line-input">
                </td>
                <td class="center">
                    <input type="text" name="street_barangay" class="line-input line-center">
                    <span class="cell-label-top">Street &<br>Barangay</span>
                </td>
                <td class="center">
                    <input type="text" name="municipality" class="line-input line-center">
                    <span class="cell-label-top">Town/City/<br>Municipality</span>
                </td>
                <td class="center">
                    <input type="text" name="province" class="line-input line-center">
                    <span class="cell-label-top">Province</span>
                </td>
                <td class="center">
                    <input type="text" name="zip_code" class="line-input line-center">
                </td>
            </tr>

            {{-- SEX / SCHOOL NAME --}}
            <tr>
                <td class="label">Sex</td>
                <td class="top">
                    <div class="checks-vertical">
                        <label><input type="radio" name="sex" value="Male"> Male</label>
                        <label><input type="radio" name="sex" value="Female"> Female</label>
                    </div>
                </td>
                <td colspan="2" class="label center">Name of School Attended</td>
                <td colspan="3">
                    <input type="text" name="school_name" class="line-input">
                </td>
            </tr>

            {{-- CITIZENSHIP / SCHOOL ID --}}
            <tr>
                <td class="label">Citizenship</td>
                <td>
                    <input type="text" name="citizenship" class="line-input" value="FILIPINO">
                </td>
                <td class="label center">School ID Number</td>
                <td colspan="4">
                    <input type="text" name="school_id_number" class="line-input">
                </td>
            </tr>

            {{-- MOBILE / SCHOOL ADDRESS --}}
            <tr>
                <td class="label">Mobile Number</td>
                <td>
                    <input type="text" name="mobile_number" class="line-input">
                </td>
                <td class="label center">School Address</td>
                <td colspan="4">
                    <input type="text" name="school_address" class="line-input">
                </td>
            </tr>

            {{-- EMAIL / SCHOOL SECTOR / YEAR / TRIBAL --}}
            <tr>
                <td class="label">E-mail Address</td>
                <td>
                    <input type="email" name="email" class="line-input">
                </td>
                <td class="label center">School Sector</td>
                <td>
                    <div class="checks-horizontal">
                        <label><input type="radio" name="school_sector" value="Public"> Public</label>
                        <label><input type="radio" name="school_sector" value="Private"> Private</label>
                    </div>
                </td>
                <td class="label center">Year Level</td>
                <td>
                    <input type="text" name="year_level" class="line-input">
                </td>
                <td class="center">
                    <div class="label">Tribal Membership</div>
                    <span class="cell-label-top">(if applicable)</span>
                </td>
            </tr>

            {{-- DISABILITY / TRIBAL VALUE --}}
            <tr>
                <td class="no-border" style="border-left:1px solid #000 !important;"></td>
                <td class="no-border" style="border-right:1px solid #000 !important;"></td>
                <td colspan="2" class="center">
                    <div class="label">Type of Disability</div>
                    <span class="cell-label-top">(if applicable)</span>
                </td>
                <td colspan="2">
                    <input type="text" name="type_of_disability" class="line-input">
                </td>
                <td>
                    <input type="text" name="tribal_membership" class="line-input">
                </td>
            </tr>

            {{-- FAMILY BACKGROUND --}}
            <tr>
                <td colspan="7" class="section-title">FAMILY BACKGROUND</td>
            </tr>

            <tr>
                <td></td>
                <td colspan="3" class="center label">Father: ( ) Living ( ) Deceased</td>
                <td colspan="3" class="center label">Mother: ( ) Living ( ) Deceased</td>
            </tr>

            <tr>
                <td class="label">Name</td>
                <td colspan="3">
                    <input type="text" name="father_name" class="line-input">
                </td>
                <td colspan="3">
                    <input type="text" name="mother_name" class="line-input">
                </td>
            </tr>

            <tr>
                <td class="label">Address</td>
                <td colspan="3">
                    <input type="text" name="father_address" class="line-input">
                </td>
                <td colspan="3">
                    <input type="text" name="mother_address" class="line-input">
                </td>
            </tr>

            <tr>
                <td class="label">Occupation</td>
                <td colspan="3">
                    <input type="text" name="father_occupation" class="line-input">
                </td>
                <td colspan="3">
                    <input type="text" name="mother_occupation" class="line-input">
                </td>
            </tr>

            <tr>
                <td class="label">Total Parents Gross income</td>
                <td colspan="3">
                    <input type="text" name="parents_gross_income" class="line-input">
                </td>
                <td class="label center">No. of Siblings in the family</td>
                <td colspan="2">
                    <input type="text" name="siblings_count" class="line-input">
                </td>
            </tr>

            <tr>
                <td colspan="7">
                    <span class="label">Are you enjoying other educational financial assistance?</span>
                    ( ) Yes or ( ) No
                </td>
            </tr>

            <tr>
                <td colspan="7">
                    <span class="label">If yes, please specify</span><br>
                    1. <input type="text" name="assistance_specify_1" class="line-input" style="display:inline-block;width:95%;"><br>
                    2. <input type="text" name="assistance_specify_2" class="line-input" style="display:inline-block;width:95%;">
                </td>
            </tr>

            <tr>
                <td colspan="7">
                    I hereby certify that foregoing statements are true and correct.
                </td>
            </tr>

            {{-- SIGNATURE --}}
            <tr>
                <td colspan="3" class="top" style="height:48px;">
                    <input type="text" name="applicant_signature_name" class="signature-line">
                    <div class="sign-note">Signature over Printed Name of Applicant</div>
                </td>
                <td colspan="2" class="top" style="height:48px;">
                    <input type="text" name="date_accomplished" class="signature-line">
                    <div class="sign-note">Date Accomplished</div>
                </td>
                <td colspan="2" class="note-center">
                    <strong>Note:</strong> Fully accomplished form to be submitted to the CHEDRO
                </td>
            </tr>

            {{-- CHEDRO --}}
            <tr>
                <td colspan="7" class="do-not-fill">DO NOT FILL-OUT THIS PORTION FOR CHEDRO USE ONLY</td>
            </tr>

            <tr>
                <td colspan="3" class="req-cell">
                    <span class="label">Documents Attached</span><br>
                    Certificate of Registration/Enrollment (CORs/COEs) ___________________________<br>
                    Certificate of Indigency _________________________________________________<br><br>

                    <span class="label">Evaluated Processed by:</span>
                </td>
                <td colspan="4" class="req-cell center">
                    <div class="label">UniFAST Regional Coordinator</div>
                    <div class="label">DOCUMENTARY REQUIREMENTS</div>
                    <div class="mini">per Section 3 of the Memorandum Circular No. __ s. 2022.</div><br>

                    <div class="left" style="text-align:left;">
                        <strong>6.2.1. For new applicants.</strong><br>
                        Participating higher education institutions (HEIs) must submit, to the respective
                        CHED Regional Offices, a certified true copy or electronically-generated copy of the list of enrolled
                        student-applicants with total number of units enrolled, together with proof of enrollment.<br><br>

                        <strong>6.2.2. Income Requirement.</strong><br>
                        New applicants and continuing grantees shall submit a Certificate of Indigency as proof of income,
                        duly issued by the Punong Barangay where the applicant currently resides.
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="7" class="req-cell">
                    <div class="label">QUALIFICATION REQUIREMENTS</div>
                    <span class="mini">
                        As per Section 1 of the Memorandum Circular No. __ s. 2022.<br><br>
                        An applicant for this grant must be a Filipino citizen and enrolled in any CHED-recognized public or private HEI,
                        subject to the qualifications and limitations provided by UniFAST and CHED.
                    </span>
                </td>
            </tr>
        </table>

        <div class="bottom-actions">
            <button type="reset" class="btn btn-outline-secondary btn-sm">Clear</button>
            <button type="submit" class="btn btn-success btn-sm">Submit</button>
        </div>
    </form>
</div>

</body>
</html>