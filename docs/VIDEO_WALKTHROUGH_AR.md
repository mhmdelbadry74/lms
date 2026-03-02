# Arabic Video Walkthrough Script

هذا الملف هو سكريبت جاهز لتسجيل فيديو 10-15 دقيقة لشرح مشروع الـ Mini-LMS بشكل منظم ومهني.

الهدف من الفيديو:
- إظهار التفكير المعماري
- توضيح استراتيجية الـ concurrency
- شرح Docker و developer experience
- توضيح الـ trade-offs وما الذي سيتم تحسينه لاحقًا

المدة المستهدفة:
- 11 إلى 13 دقيقة

---

## قبل التسجيل

افتح هذه الملفات مسبقًا في tabs:
- `README.md`
- `docs/ARCHITECTURE.md`
- `docs/ERD.md`
- `docs/PRODUCT_THINKING.md`
- `routes/web.php`
- `app/Actions/Enrollment/EnrollUserInCourseAction.php`
- `app/Actions/Progress/CompleteLessonAction.php`
- `app/Actions/Progress/EnsureCourseCompletionAction.php`
- `app/Policies/CoursePolicy.php`
- `app/Policies/LessonPolicy.php`
- `app/Listeners/SendWelcomeEmail.php`
- `app/Listeners/SendCourseCompletedEmail.php`
- `tests/Feature/EnrollmentFlowTest.php`
- `docker-compose.yml`
- `Dockerfile`

وشغّل التطبيق قبل التسجيل إذا كنت ستعرض الـ UI.

---

## 0:00 - 1:00 | مقدمة سريعة

### ماذا تقول

"المشروع ده عبارة عن Mini-LMS مبني بـ Laravel 12، والهدف منه بناء core foundation صحيحة وقابلة للتوسع، وليس مجرد prototype سريع.

الـ scope الأساسي هنا هو:
- عرض الكورسات المنشورة
- التسجيل
- الـ enrollment
- إكمال الدروس
- إنشاء الشهادة عند اكتمال الكورس

أنا كنت مركز بالأساس على correctness، منع التكرار، والحفاظ على اتساق البيانات لو حصل retries أو rapid clicks أو حتى تغييرات في محتوى الكورس بعد enrollment."

### ماذا تفتح
- `README.md`
- نظرة سريعة على الـ project structure

### الرسالة الأساسية
- المشروع مبني كأساس هندسي، وليس مجرد demo UI.

---

## 1:00 - 3:00 | المعمارية العامة

### ماذا تقول

"المعمارية هنا مبنية حول الـ business flows.

بدل ما أضع الـ logic داخل الـ routes أو الـ Livewire components، فصلت الـ flows الأساسية داخل Action classes.

الـ public browsing مفتوح.
الـ preview lessons متاحة للزوار.
أما الـ enrollment والـ completion فهما flows تتطلب authentication.

كمان استخدمت Policies لعزل قواعد الوصول، بحيث منطق الوصول للبيانات لا يكون مبعثرًا داخل الواجهات."

### ماذا تفتح
- `docs/ARCHITECTURE.md`
- `routes/web.php`
- `app/Actions/Enrollment/EnrollUserInCourseAction.php`
- `app/Actions/Progress/CompleteLessonAction.php`
- `app/Actions/Progress/EnsureCourseCompletionAction.php`
- `app/Policies/CoursePolicy.php`
- `app/Policies/LessonPolicy.php`

### نقاط مهمة تذكرها
- `EnrollUserInCourseAction` مسؤول عن enrollment بشكل idempotent
- `CompleteLessonAction` يسجل progress ثم يفوض التحقق من اكتمال الكورس
- `EnsureCourseCompletionAction` هو قلب منطق completion/certificate
- الـ Policies تمنع أي cross-user exposure

### الرسالة الأساسية
- الـ architecture مبنية حول business flows واضحة وسهلة التوسع.

---

## 3:00 - 5:00 | تصميم قاعدة البيانات والقيود

### ماذا تقول

"أول خط دفاع عندي هو قاعدة البيانات.

أي flow لازم يحصل مرة واحدة فقط، أحاول أحميه أولًا بـ DB constraints، وبعدها أضيف application-level guards.

هذا يقلل مشاكل race conditions تحت الضغط أو في حالة تكرار نفس الطلب."

### ماذا تفتح
- `docs/ERD.md`
- `database/migrations/2026_03_01_000001_create_courses_table.php`
- `database/migrations/2026_03_01_000003_create_enrollments_table.php`
- `database/migrations/2026_03_01_000004_create_lesson_progress_table.php`
- `database/migrations/2026_03_01_000005_create_course_completions_table.php`
- `database/migrations/2026_03_01_000006_create_certificates_table.php`
- `app/Models/Course.php`

### لازم تذكر بوضوح
- `enrollments`: unique على `user_id + course_id`
- `lesson_progress`: unique على `user_id + lesson_id`
- `course_completions`: unique على `user_id + course_id`
- `certificates`: unique على `uuid` و `user_id + course_id`
- `lessons`: unique على `course_id + position`
- `courses.slug`: unique

### نقطة مهمة جدًا

"عند soft delete للكورس، أنا بغيّر الـ slug تلقائيًا، وده يحرر الـ slug الأصلي لإعادة استخدامه بدون خرق uniqueness."

### الرسالة الأساسية
- النزاهة هنا enforced على مستوى البنية، وليس فقط عبر request validation.

---

## 5:00 - 7:30 | استراتيجية الـ Concurrency

### ماذا تقول

"أهم مخاطر الـ LMS الصغير ده هي:
- duplicate enrollment
- duplicate lesson completion
- duplicate certificate creation
- duplicate emails

عشان كده استخدمت طبقات حماية متعددة:
- DB constraints
- transactions
- `firstOrCreate()`
- event dispatch بعد الـ commit
- idempotency guards على مستوى الـ listeners"

### ماذا تفتح
- `app/Actions/Enrollment/EnrollUserInCourseAction.php`
- `app/Actions/Progress/CompleteLessonAction.php`
- `app/Actions/Progress/EnsureCourseCompletionAction.php`
- `app/Listeners/SendWelcomeEmail.php`
- `app/Listeners/SendCourseCompletedEmail.php`

### ماذا تشرح

#### Enrollment
- لو المستخدم ضغط أكثر من مرة أو حصل retry، الـ unique constraint يمنع duplicate rows
- `firstOrCreate()` داخل transaction يجعل العملية idempotent

#### Lesson Completion
- نفس الدرس لو تم استكماله أكثر من مرة، يظل هناك progress record واحد فقط
- لا يتم إنشاء duplicate completion state لهذا الدرس

#### Course Completion
- الإكمال لا يُحسب من مجرد آخر request
- بل يتم حسابه بناءً على required lessons الحالية
- إذا لم يكتمل الكورس، لا يتم إنشاء completion
- وإذا اكتمل، يتم إنشاء completion وcertificate مرة واحدة

#### Emails
- الـ listeners تعمل كـ queued listeners
- وهناك guard على مستوى الـ cache يمنع تكرار الإرسال لو حصل retry أو duplicate dispatch

### نقطة مميزة جدًا

"لو الكورس اتعدل بعد enrollment وتمت إضافة required lesson جديدة، فالنظام يعيد تقييم completion.
ولو المستخدم لم يكمل الدرس الجديد، يتم إلغاء completion والشهادة القديمة حتى يعود النظام لحالة منطقية متسقة."

### الرسالة الأساسية
- النظام مصمم ليظل صحيحًا تحت الضغط، وليس فقط في happy path.

---

## 7:30 - 9:00 | Livewire و Alpine والـ UX

### ماذا تقول

"الواجهة هنا intentionally بسيطة، لكني نفذت الـ interaction patterns الأساسية المطلوبة في التحدي.

استخدمت Livewire للصفحات server-driven، واستخدمت Alpine للحالة المحلية داخل الـ UI.

الفكرة كانت أن يظل الـ frontend خفيفًا، بينما correctness تظل محكومة من الـ backend."

### ماذا تفتح
- `app/Livewire/Public/Home.php`
- `app/Livewire/Courses/ShowCourse.php`
- `app/Livewire/Lessons/ShowLesson.php`
- `resources/views/livewire/courses/show-course.blade.php`
- `resources/views/livewire/lessons/show-lesson.blade.php`
- `resources/views/layouts/app.blade.php`

### المتطلبات التي تذكرها بالاسم
- Accordion lesson list
- Confirmation modal قبل completion
- Animated progress bar
- Dark mode toggle
- Plyr lifecycle placeholder عبر Alpine

### كن صريحًا

"الـ Plyr موجود حاليًا كـ placeholder منظم، وليس integration نهائي كامل.
أنا فضّلت أنهي طبقة الـ integrity أولًا، ثم media integration في iteration لاحقة."

### الرسالة الأساسية
- الواجهة تغطي المطلوب، لكن الأولوية كانت لصحة البنية والمنطق.

---

## 9:00 - 10:30 | Docker و Developer Experience

### ماذا تقول

"المشروع Dockerized لتسهيل تشغيله على الـ reviewer.

الـ reviewer flow هنا واضح:
- تشغيل الحاويات
- تشغيل migrations و seeders
- تشغيل الاختبارات

وكل الأوامر الأساسية موثقة في الـ README."

### ماذا تفتح
- `docker-compose.yml`
- `Dockerfile`
- `nginx/default.conf`
- `README.md`

### اشرح الخدمات
- `app`
- `web`
- `db`
- `queue`

### اذكر الأوامر بصوتك
- `docker compose up --build`
- `docker compose exec app composer install`
- `docker compose exec app php artisan key:generate`
- `docker compose exec app php artisan migrate --seed`
- `docker compose exec app php artisan test`

### قل هذه النقطة بصراحة

"أنا تحققت من التطبيق والاختبارات محليًا داخل البيئة الحالية، لكن لم أقم بعمل clean-machine Docker verification كاملة داخل هذه الجلسة."

### الرسالة الأساسية
- الـ DX واضح، وصادق، وقابل للمراجعة.

---

## 10:30 - 11:45 | الاختبارات كإثبات صحة

### ماذا تقول

"أنا تعاملت مع الاختبارات كإثبات للـ integrity، وليس مجرد route checks.

ركزت على السيناريوهات التي تُظهر صحة النظام تحت التكرار أو تغير الحالة."

### ماذا تفتح
- `tests/Feature/EnrollmentFlowTest.php`

### اذكر السيناريوهات بالاسم
- welcome email عند التسجيل
- منع duplicate enrollment
- منع enrollment في draft courses
- إنشاء certificate واحدة فقط عند اكتمال الكورس
- الحفاظ على uniqueness للـ slug مع soft delete
- منع وصول المستخدم غير الـ enrolled إلى non-preview lessons
- إلغاء completion إذا تمت إضافة required lesson جديدة لاحقًا

### نقطة مهمة

"التحدي طلب Pest، لكن البيئة كانت offline، لذلك استخدمت PHPUnit لتغطية نفس السلوكيات المطلوبة فعليًا."

### الرسالة الأساسية
- حتى مع القيود، تم الحفاظ على الجوهر المطلوب: إثبات correctness.

---

## 11:45 - 13:00 | الـ Trade-offs وما الذي سأطوره لاحقًا

### ماذا تقول

"في المشروع ده اتخذت trade-offs واضحة ومقصودة."

### استخدم هذه النقاط

#### 1. فضّلت correctness على توسيع الـ admin surface
- ركزت على core domain logic بدل بناء Filament admin كاملة
- لأن الوزن الأكبر في التقييم هنا للـ architecture والـ integrity

#### 2. أنشأت الشهادة مباشرة عند تحقق completion
- هذا يحافظ على اتساق قوي بين completion state وcertificate state
- لكنه يربط certificate creation بلحظة التحقق من الإكمال

#### 3. استخدمت PHPUnit بدل Pest
- لأن البيئة كانت بدون package registry access
- لكني حافظت على نفس التغطية المطلوبة سلوكيًا

### ماذا سأطور لاحقًا
1. دمج Plyr فعليًا بدل placeholder
2. إضافة Filament resources للكورسات والدروس
3. تحويل الاختبارات إلى Pest عندما يصبح تثبيت الحزم متاحًا
4. إضافة analytics/event tracking للـ metrics الموجودة في `docs/PRODUCT_THINKING.md`
5. عمل Docker verification كاملة على clean machine وتحسين DX لو ظهرت gaps

### الرسالة الأساسية
- أنت تعرف بالضبط ما الذي اكتمل، وما الذي هو الـ next step.

---

## ترتيب الـ Demo على الشاشة

اعرض الفيديو بهذا الترتيب:

1. افتح الصفحة الرئيسية واعرض الكورسات المنشورة
2. افتح صفحة كورس
3. اعرض الـ accordion للـ lessons
4. وضح أن preview lessons متاحة
5. اعمل login أو register
6. اعمل enrollment
7. افتح صفحة درس
8. اعرض progress bar وconfirmation modal
9. بعد ذلك انتقل للكود واشرح الـ Actions
10. ثم انتقل للاختبارات
11. ثم اختم بـ README وDocker commands

---

## العبارات القوية المقترحة أثناء الكلام

استخدم عبارات مثل:
- "أنا ركزت على correctness تحت retries."
- "قاعدة البيانات هي أول boundary للـ integrity."
- "أبقيت الـ HTTP layer thin، ونقلت الـ business logic إلى Actions."
- "هذا كان trade-off مقصود."
- "في iteration تالية، سأضيف..."

تجنب:
- "أنا بس عملت..."
- "ده بسيط..."
- "ما لحقتش..."

واستبدلها بـ:
- "أنا فضّلت..."
- "أنا intentionally scoped..."
- "المرحلة التالية ستكون..."

---

## ملاحظات أخيرة

- لا تحاول تبدو أن كل شيء production-complete.
- الصراحة هنا أقوى من المبالغة.
- أهم ما يجب أن يظهر في الفيديو:
  - أنك تفهم الـ system boundaries
  - أنك تفهم الـ concurrency risks
  - أنك اتخذت trade-offs واعية
  - أنك تعرف بوضوح ما الذي ستبنيه في الـ next iteration
