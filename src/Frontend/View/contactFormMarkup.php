<div class="p-4 mx-auto max-w-xl bg-white">
  <h2 class="text-3xl text-slate-900 font-bold">Contact us</h2>
  <form class="mt-8 space-y-5" method="POST" action="/">
  <?php echo wp_nonce_field('bk_contact_form','bk_ct_form_nonce') ?>
  <div>
      <label class='text-sm text-slate-900 font-medium mb-2 block'>Name</label>
      <input name="name" type='text' placeholder='Enter Name'
        class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />
    </div>
    <div>
      <label class='text-sm text-slate-900 font-medium mb-2 block'>Email</label>
      <input name="email" type='email' placeholder='Enter Email'
        class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />
    </div>
    <div>
      <label class='text-sm text-slate-900 font-medium mb-2 block'>Subject</label>
      <input name="subject" type='text' placeholder='Enter Subject'
        class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm outline-0 transition-all" />
    </div>
    <div>
      <label class='text-sm text-slate-900 font-medium mb-2 block'>Message</label>
      <textarea name="message" placeholder='Enter Message' rows="6"
        class="w-full px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 focus:bg-transparent text-sm pt-3 outline-0 transition-all"></textarea>
    </div>
    <input type='submit' name="bk_form_submit_btn" value="Send message"
      class="text-white bg-slate-900 font-medium hover:bg-slate-800 tracking-wide text-sm px-4 py-2.5 w-full border-0 outline-0 cursor-pointer"/>
  </form>
</div>