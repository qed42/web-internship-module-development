## To get data of the form: 
`ddev drush php-eval 'var_dump(\Drupal::state()->get("virag_form_api.user_data"));'`

## Form_api
1. uses buildForm, ValidateForm, SubmitForm methods for creation, validation, submittion of the form.
2. Two methods to store data, Session [Temporary storage] & State API [stores data in database].
3. created a cron job to run every 1hr and delete state data.