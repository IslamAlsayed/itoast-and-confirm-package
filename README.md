## Laravel Flash Notification Component

#### يمكتك استخدام حزمة بسطة واحترافية لعرض الاشعارات

## ✅ المميزات

دعم متعدد لأنواع التنبيهات: ✅ نجاح، ❌ خطأ، ⚠️ تحذير، ℹ️ معلومات

- دعم متعدد لأنواع التنبيهات (success, error, info, warn)
- دعم الأيقونات والإيموجي
- دعم العناوين والنصوص
- إمكانية التثبيت (Pin)
- تخصيص المدة الزمنية للعرض
- تحديد موضع الظهور (مثل: أعلى، يمين)
- دعم الاتجاهات: ltr و rtl
- دعم السمات (Themes): success, error, info, warn
- إمكانية عرض أزرار: (Confirm / Cancel) => (Yes / No)
- دعم إجراءات إضافية قابلة للتخصيص

## التثبيت

### 1. تثبيت الباكيج عبر Composer:

```php
composer require islam/itoast
```

#### 2. نشر جميع الملفات:

```php
php artisan vendor:publish --tag=itoast-all
```

### الاستخدام

يمكنك تشغيل `confirm` باستخدام أي من الطرق التالية:

### Confirms (إشعار تأكيد)

#### ✅ 1.1. Using Helper functions

```php
addConfirm('Operation completed successfully');
addConfirmSuccess('Operation completed successfully');
addConfirmError('Are you sure?')->icon('check')->title('Error');
addConfirmWarn('Please fill out all fields')->icon('check')->title('Warn');
addConfirmInfo('Block user?')->icon('check')->title('info');
```

or

#### ✅ 1.2. Using the `IToast` static class

```php
IToast::confirm()->icon('check')->title('delete');
IToast::confirm('Are you sure you want to update the item?')->title('update')->emoji('✅')->onConfirm('🙃')->onCancel('🙂')->withAction('More Info', '/details');
IToast::confirm('Delete this item?')->title('delete')->icon('circle-check')->onConfirm('✅')->onCancel('❌')->theme('success');
IToast::confirm('Are you sure?')->icon('check-double')->title('Update')->theme('error')->onConfirm('👍')->onCancel('👎');
IToast::confirm('Block user?')->emoji('🔥')->icon('square-check')->title('Block')->theme('info')->onConfirm('Block')->onCancel('Cancel');
```

or

#### ✅ 1.3. Using `IToastManager` the class-based approach

```php
(new IToastManager)->add('confirm', 'Saved successfully')->theme('success');
(new IToastManager)->add('confirm', 'Delete this item?')->theme('error');
(new IToastManager)->add('confirm', 'Are you sure?')->theme('warn');
(new IToastManager)->add('confirm', 'Block user?')->theme('info');
```

### Confirms

![Confirms](./src/Resources/assets/images/confirms.png)

يمكنك تشغيل `itoast` او باستخدام أي من الطرق التالية:

### Itoasts (إشعار لحظي)

#### ✅ 2. Using the `IToast` static class

```php
addItoastSuccess('Operation completed successfully')->duration('2s');
addIToast('success', 'Saved successfully')->duration(5000);
(new IToastManager)->add('success', 'Item saved successfully')->pin()->emoji('🎉')->title('Success')->duration('0.3s');
IToast::success('Data updated')->icon('check-circle')->duration('0.9s')->withAction('Undo', '/undo-url');
```

### Success (إشعار نجاح)

![Success](./src/Resources/assets/images/success.png)

#### ✅ 3. Using the `IToast` static class

```php
addItoastError('Something went wrong')->icon('bug')->duration('2s');
addIToast('error', 'Saved not successfully')->pin();
(new IToastManager)->add('error', 'Failed to save item')->emoji('💥')->title('Error')->duration('0.3s');
IToast::error('Server error')->icon('bomb')->duration('0.9s')->withAction('Retry', '/retry');
```

### Error (إشعار خطأ)

![Error](./src/Resources/assets/images/error.png)

#### ✅ 4. Using the `IToast` static class

```php
addItoastWarn('Please fill out all fields')->icon('car-on')->duration('2s');
addIToast('warn', 'Saved not successfully')->pin()->icon('radiation');
(new IToastManager)->add('warn', 'Unsaved changes')->emoji('⛔')->title('warn')->duration('0.3s');
IToast::warn('Check your input')->icon('skull-crossbones')->duration('0.9s')->withAction('Fix', '/fix-form');
```

### Warn (إشعار تحذير)

![Warn](./src/Resources/assets/images/warn.png)

#### ✅ 5. Using the `IToast` static class

```php
addItoastInfo('System will restart at 10 PM')->icon('sitemap')->duration('3s');
addIToast('info', 'New update available')->pin()->icon('infinity');
(new IToastManager)->add('info', 'Unsaved changes')->emoji('🔔')->title('info');
IToast::info('View release notes')->icon('stethoscope')->duration('1.5s')->withAction('Dismiss', '/dismiss');
```

### Info (إشعار معلومات)

![Info](./src/Resources/assets/images/info.png)

#### ✅ 6. Using Laravel session (flash)

```php
# Direct session with use flash for temporary messages
session()->flash('warn', 'Please check your inputs');
session()->flash('success', [
    'title' => 'Saved',
    'message' => 'Saved successfully',
    'emoji' => '🔥',
    'duration' => '2m',
    'position' => 'right',
    'pin' => 'pin',
    'actions' => [['label' => 'تفاصيل', 'url' => '/details'], ['label' => 'تراجع', 'url' => '/oops']],
]);
```

#### ✅ 7. With redirect responses

```php
return redirect()->back()->with('success', 'Action completed');
return redirect()->route('dashboard')->with('success', 'Welcome you in dashboard');
return redirect()->route('home')->with('error', 'Something went wrong');
return redirect()->route('profile')->with('warn', 'Please fill out all fields');
return redirect()->route('home')->with('info', 'View release notes');
```

### يمكنك استخدام الحزمة مع اللغة العربية ايضا

### Confirms (إشعار تأكيد)

![Confirms](./src/Resources/assets/images/confirms_ar.png)

### Success (إشعار نجاح)

![Success](./src/Resources/assets/images/success_ar.png)

### Error (إشعار خطأ)

![Error](./src/Resources/assets/images/error_ar.png)

### Warn (إشعار تحذير)

![Warn](./src/Resources/assets/images/warn_ar.png)

### Info (إشعار معلومات)

![Info](./src/Resources/assets/images/info_ar.png)

يمكنك أيضًا ربط الخيارات الإضافية:

### الخصائص

```php
public $type;
public $message;
public $title = null;
public $emoji = null;
public $icon = null;
public $duration = null;
public $position = null;
public $pin = null;
public $theme = null;
public $dir = null;
public $confirm = null;
public $cancel = null;
public $actions = [];
```

| الخاصية  | النوع  | الوصف                                                 |                                           |
| :------- | :----- | :---------------------------------------------------- | :---------------------------------------- |
| type     | string | some are require                                      | (فقط): success, error, info, warn         |
| message  | string | message text                                          | نص رسالة الأشعار                          |
| title    | string | null                                                  | (اختياري) نص عنوان الأشعار                |
| emoji    | string | null                                                  | (فقط): إموجي جنب العنوان => emoji         |
| icon     | string | null                                                  | icon من FontAwesome مثلا او emoji         |
| duration | int    | null                                                  | مدة العرض بالمللي ثانية والثواني والدقائق |
| position | string | null                                                  | (فقط): موقع الدخول => top or right        |
| pin      | bool   | null                                                  | تثبيت وعدم الاختفاء التلقائي              |
| theme    | string | null                                                  | (فقط): success, error, info, warn         |
| dir      | string | null                                                  | (فقط): اتجاه الاشعار والنصوص => rtl, ltr  |
| confirm  | string | null                                                  | (Yes) نص زرار الموافقة                    |
| cancel   | string | null                                                  | (No) نص زرار الإلغاء                      |
| actions  | array  | [['label' => 'تفاصيل' 'url' => '/details-url'], ... ] | إضافة إجراءات إضافية في الإشعار           |

---

## اقتراحات مستقبلية

- دعم Queue للتنبيهات المتعددة بالتتابع
- دعم صوت للتنبيه
- تخزين التنبيهات في الجلسة أو الكوكيز للعرض بعد إعادة التوجيه
- تضمين Animation جاهزة مثل fadeIn, slideOut وغيرها

---

## ➖ 🛠️ المساهمة في المشروع

هل لديك أفكار أو تحسينات؟ نرحب بمساهماتك!

- افتح Issue.
- أو قدم Pull Request.

---

## ➖ 📬 تواصل معي

- 📧 **الإيميل**: [eslamalsayed8133@gmail.com](mailto:eslamalsayed8133@gmail.com)
- 💼 **لينكدإن**: [IslamAlsayed](https://www.linkedin.com/in/islam-alsayed7)
- 💼 **فيسبوك**: [IslamAlsayed](https://www.facebook.com/islamalsayed00)

---

> ✨ تم تطوير هذا المشروع لتسهيل عرض اشعار للمستخدم بشكل سهل وبسيط ومميز
