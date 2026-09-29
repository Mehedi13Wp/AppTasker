<?php
namespace Database\Seeders;
use App\Models\Task;
use Illuminate\Database\Seeder;
class DemoWorkerTaskSeeder extends Seeder {
 public function run(): void {
  $tasks=[
   ['title'=>'Resize Image to 1080 × 1080','type'=>'image_resize','description'=>'Download the source image, open the assigned Android utility app, resize it to 1080 × 1080, then return to AppTasker with the processed file.','reward'=>5,'slot'=>'morning','status'=>'available','app_name'=>'AppTasker Image Tool','requirements'=>['width'=>'1080 px','height'=>'1080 px','keep_content'=>'Do not crop important content']],
   ['title'=>'Resize Video to 720p','type'=>'video_resize','description'=>'Download the source video, process it inside the assigned Android utility app at 720p, then return to AppTasker with the output video.','reward'=>10,'slot'=>'afternoon','status'=>'available','app_name'=>'AppTasker Video Tool','requirements'=>['resolution'=>'1280 × 720','duration'=>'Keep original duration','content'=>'Do not alter video content']],
   ['title'=>'Convert PNG Image to JPG','type'=>'image_convert','description'=>'Download the PNG source image, use the assigned Android utility app to convert it to JPG, then return to AppTasker with the converted file.','reward'=>5,'slot'=>'evening','status'=>'available','app_name'=>'AppTasker Convert Tool','requirements'=>['input'=>'PNG','output'=>'JPG','content'=>'Keep the original image content']],
  ];
  foreach($tasks as $task){ Task::updateOrCreate(['title'=>$task['title']],$task); }
 }
}