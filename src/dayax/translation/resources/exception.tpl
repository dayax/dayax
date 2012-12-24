namespace %%namespace%%
{
    use dayax\i18n\Translator;
    class %%class%% extends %%extends%%
    {    
        private $message_code = null;
        public function __construct()
        {
            $args = func_get_args(); 
            $this->message_code = @$args[0];
            $message = Translator::translate(func_get_args());
            parent::__construct($message);
        }
        public function getMessageCode()
        {
            return $this->message_code;
        }
    }//end of class
}//end of namespace