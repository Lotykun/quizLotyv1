function on_msg_receive (msg)
	if msg.out then
          	return
	end
      	if string.starts(msg.text, "QuizLotyv1") then
            execute_script = 'php /home/jlotito/repositories/git/quizLotyv1/telegramsdk.php "' .. msg.text .. '" ' .. msg.from.print_name .. ' ' .. msg.from.phone
            local handle = io.popen(execute_script)
            local result = handle:read("*a")
            handle:close()
            send_msg (msg.from.print_name, result, ok_cb, false)
        end
end

function on_our_id (id)
  our_id = id
end

function on_user_update (user, what)
  --vardump (user)
end

function on_chat_update (chat, what)
  --vardump (chat)
end

function on_secret_chat_update (schat, what)
  --vardump (schat)
end

function on_get_difference_end ()
end

function cron()
  -- do something
  postpone (cron, false, 1.0)
end

function on_binlog_replay_end ()
  started = 1
  postpone (cron, false, 1.0)
end

function string.starts(String,Start)
   return string.sub(String,1,string.len(Start))==Start
end

function string.ends(String,End)
   return End=='' or string.sub(String,-string.len(End))==End
end
