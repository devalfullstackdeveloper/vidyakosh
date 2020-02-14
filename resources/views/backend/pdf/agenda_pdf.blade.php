<!DOCTYPE html>
<html>
    <head>
        <title>Agenda PDF</title>
        <link rel="stylesheet" href="http://103.101.59.95/vidyakosh/public/assets/css/bootstrap.min.css">
        <script src="http://103.101.59.95/vidyakosh/public/assets/js/bootstrap.min.js"></script>
        <style>
            .deptLogo{
                height: 50px;
                width: 177px;
            }
            .digitalIndLogo{
                height: 100px;
                width: 200px;
            }
            .font-14{
                font-size: 14px;
            }
            .font-11{
                font-size: 11px;
                line-height: 2.5;
            }
            
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mt-4">
<!--                    <img src="{{ url('/department-logo/{$deptLogo}') }}" class="deptLogo">-->
                    <img src="<?php echo url('/assets/images/'.$deptLogo) ?>" class="deptLogo">
                </div>
                <div class="col-lg-6">
                    <img src="{{ url('/images/digital-india-logo.png') }}" class="digitalIndLogo float-right">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-2">
                    <br>
                    <p class="text-center font-14">{{ $ministry }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-2">
                    <p class="text-center font-14">{{ $department }}</p><br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mt-2">
                    <p class="float-right font-14">{{ $training }}</p><br>                 
                </div>
            </div>
            <div class="row font-11">
                <div class="col-lg-12 mt-2">
                <?php $cnt = 1; ?>
                @foreach($agenda as $date => $agendaData)
                <p>Day {{$cnt}} ({{$date}})</p>
                <table class="table mb-2">
                    <thead>
                        <tr>
                            <td>Sr No.</td>
                            <td>From</td>
                            <td>To</td>
                            <td>Title</td>
                            <td>Speaker</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($agendaData as $key => $value) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value['session_duration_from']; ?></td>
                                <td><?php echo $value['session_duration_to']; ?></td>
                                <td><?php echo $value['title']; ?></td>
                                <td><?php echo $value['speaker']; ?></td>
                            </tr>
                            <?php
                            $i = $i + 1;
                        }
                        ?>
                    </tbody>
                </table>
                <?php $cnt = $cnt + 1; ?>
                @endforeach
                </div>
            </div>
        </div>
    </body>
</html>