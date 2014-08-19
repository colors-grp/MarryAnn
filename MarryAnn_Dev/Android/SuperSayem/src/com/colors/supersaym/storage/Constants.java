package com.colors.supersaym.storage;

import java.io.InputStream;
import java.io.OutputStream;

public class Constants {

	public static final String appPreferencesName = "settings";

	public static String userName="facebook_name";
	public static String userID="facebook_id";
    public static void CopyStream(InputStream is, OutputStream os)
    {
        final int buffer_size=1024;
        try
        {
            byte[] bytes=new byte[buffer_size];
            for(;;)
            {
              int count=is.read(bytes, 0, buffer_size);
              if(count==-1)
                  break;
              os.write(bytes, 0, count);
            }
        }
        catch(Exception ex){}
    }
}
