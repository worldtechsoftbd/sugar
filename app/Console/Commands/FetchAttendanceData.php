<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;


class FetchAttendanceData extends Command
{
    protected $signature = 'fetch:attendance';

    protected $description = 'Fetch data from remote Access database and insert into local MySQL database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dbFile = "G:/xampp 8.2 latest/htdocs/database/attBackup.mdb";    // Update with actual path if needed
        $connStr = "odbc:Driver={Microsoft Access Driver (*.mdb, *.accdb)};Dbq=$dbFile;";

        try {
            // Connecting to the remote Access database
            $pdo = new PDO($connStr);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query to fetch data from the CHECKINOUT table where VerifyCode = 0
            $query = "SELECT * FROM CHECKINOUT WHERE VerifyCode = 0";
            $stmt = $pdo->query($query);

            // Loop through the results and process them
            foreach ($stmt as $row) {
                $USERID = $row['USERID'];
                $CHECKTIME = $row['CHECKTIME'];
                $SENSORID = $row['SENSORID'];
                $CHECKTYPE = $row['CHECKTYPE'];
                $VERIFYCODE = $row['VERIFYCODE'];
                $Memoinfo = $row['Memoinfo'];
                $WorkCode = $row['WorkCode'];
                $sn = $row['sn'];
                $UserExtFmt = $row['UserExtFmt'];

                // Insert into MySQL database (you need to set up the MySQL connection)
                if (  $VERIFYCODE != 1) {
                    DB::table('device_attendances')->insert([
                        'userId' => $USERID,
                        'status' => 101, // Assuming 101 is the status value
                        'checkTime' => $CHECKTIME,
                        'checkType' => $CHECKTYPE,
                        'verifyCode' => $VERIFYCODE,
                        'sensorId' => $SENSORID,
                        'memoInfo' => $Memoinfo,
                        'workCode' => $WorkCode,
                        'sn' => $sn,
                        'userExtFmt' => $UserExtFmt
                    ]);
                }

                // Update the CHECKINOUT table on the remote database
                $updateQuery = "UPDATE CHECKINOUT SET VerifyCode = 1 WHERE USERID = :USERID AND CHECKTIME = :CHECKTIME AND SENSORID = :SENSORID";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->execute([
                    ':USERID' => $USERID,
                    ':CHECKTIME' => $CHECKTIME,
                    ':SENSORID' => $SENSORID
                ]);
            }

            $this->info('Data fetch and update completed successfully.');

        } catch (PDOException $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
