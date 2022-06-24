<?php

namespace common\models;

use Yii;

class ProjectEmpAttendance extends \yii\db\ActiveRecord
{
    public $file;
    public static function tableName()
    {
        return 'project_emp_attendance';
    }

    public function rules()
    {
        return [
            [['project_emp_id', 'month', 'days', 'hours','project_id'], 'required'],
            [['project_emp_id','project_id'], 'integer'],
            [['month'], 'safe'],
            [['days', 'hours'], 'number'],
            [['day1_in', 'day1_out', 'day2_in', 'day2_out', 'day3_in', 'day3_out', 'day4_in', 'day4_out', 'day5_in', 'day5_out', 'day6_in', 'day6_out', 'day7_in', 'day7_out', 'day8_in', 'day8_out', 'day9_in', 'day9_out', 'day10_in', 'day10_out', 'day11_in', 'day11_out', 'day12_in', 'day12_out', 'day13_in', 'day13_out', 'day14_in', 'day14_out', 'day15_in', 'day15_out', 'day16_in', 'day16_out', 'day17_in', 'day17_out', 'day18_in', 'day18_out', 'day19_in', 'day19_out', 'day20_in', 'day20_out', 'day21_in', 'day21_out', 'day22_in', 'day22_out', 'day23_in', 'day23_out', 'day24_in', 'day24_out', 'day25_in', 'day25_out', 'day26_in', 'day26_out', 'day27_in', 'day27_out', 'day28_in', 'day28_out', 'day29_in', 'day29_out', 'day30_in', 'day30_out', 'day31_in', 'day31_out'], 'string', 'max' => 10],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_emp_id' => 'Project Emp ID',
            'month' => 'Month',
            'days' => 'Days',
            'hours' => 'Hours',
            'day1_in' => 'Day1 In',
            'day1_out' => 'Day1 Out',
            'day2_in' => 'Day2 In',
            'day2_out' => 'Day2 Out',
            'day3_in' => 'Day3 In',
            'day3_out' => 'Day3 Out',
            'day4_in' => 'Day4 In',
            'day4_out' => 'Day4 Out',
            'day5_in' => 'Day5 In',
            'day5_out' => 'Day5 Out',
            'day6_in' => 'Day6 In',
            'day6_out' => 'Day6 Out',
            'day7_in' => 'Day7 In',
            'day7_out' => 'Day7 Out',
            'day8_in' => 'Day8 In',
            'day8_out' => 'Day8 Out',
            'day9_in' => 'Day9 In',
            'day9_out' => 'Day9 Out',
            'day10_in' => 'Day10 In',
            'day10_out' => 'Day10 Out',
            'day11_in' => 'Day11 In',
            'day11_out' => 'Day11 Out',
            'day12_in' => 'Day12 In',
            'day12_out' => 'Day12 Out',
            'day13_in' => 'Day13 In',
            'day13_out' => 'Day13 Out',
            'day14_in' => 'Day14 In',
            'day14_out' => 'Day14 Out',
            'day15_in' => 'Day15 In',
            'day15_out' => 'Day15 Out',
            'day16_in' => 'Day16 In',
            'day16_out' => 'Day16 Out',
            'day17_in' => 'Day17 In',
            'day17_out' => 'Day17 Out',
            'day18_in' => 'Day18 In',
            'day18_out' => 'Day18 Out',
            'day19_in' => 'Day19 In',
            'day19_out' => 'Day19 Out',
            'day20_in' => 'Day20 In',
            'day20_out' => 'Day20 Out',
            'day21_in' => 'Day21 In',
            'day21_out' => 'Day21 Out',
            'day22_in' => 'Day22 In',
            'day22_out' => 'Day22 Out',
            'day23_in' => 'Day23 In',
            'day23_out' => 'Day23 Out',
            'day24_in' => 'Day24 In',
            'day24_out' => 'Day24 Out',
            'day25_in' => 'Day25 In',
            'day25_out' => 'Day25 Out',
            'day26_in' => 'Day26 In',
            'day26_out' => 'Day26 Out',
            'day27_in' => 'Day27 In',
            'day27_out' => 'Day27 Out',
            'day28_in' => 'Day28 In',
            'day28_out' => 'Day28 Out',
            'day29_in' => 'Day29 In',
            'day29_out' => 'Day29 Out',
            'day30_in' => 'Day30 In',
            'day30_out' => 'Day30 Out',
            'day31_in' => 'Day31 In',
            'day31_out' => 'Day31 Out',
        ];
    }
	public function getProject()
    {
        return $this->hasOne(ProjectDetails::className(), ['id' => 'project_id']);
    }
	public function getEmployee()
    {
        return $this->hasOne(ProjectEmp::className(), ['id' => 'project_emp_id']);
    }
}
