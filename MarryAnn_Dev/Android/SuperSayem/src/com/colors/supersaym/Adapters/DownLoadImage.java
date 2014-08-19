package com.colors.supersaym.Adapters;


import java.io.InputStream;
import java.net.URL;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.widget.ImageView;


public class DownLoadImage extends AsyncTask <String, Integer, Bitmap>
{
	ImageView img;
	Bitmap mIcon11 = null;
	String path;
	public DownLoadImage(ImageView adsImage) 
	{
		img=adsImage;
	}
	@Override
	protected Bitmap doInBackground(String... params) 
	{
		try 
        {
			System.gc();
			path=params[0];
            InputStream in = new URL(path).openStream();
            BitmapFactory.Options options = new BitmapFactory.Options();
			options.inJustDecodeBounds = false;
			options.inSampleSize=1;
		    mIcon11 = BitmapFactory.decodeStream(in);//,new Rect(0, 0, 72, 72),options);
            in.close();
        }
        catch (Exception e) 
        {
        	mIcon11=null;
        }
        return mIcon11;
	}
	@Override
	protected void onPostExecute(Bitmap bitmap) 
	{
		super.onPostExecute(bitmap);
		if(mIcon11!=null&&path!=null)
		{
			img.setImageBitmap(mIcon11);
		}
		else
		{
			//img.setImageResource(R.drawable.logo_page);
		}
		mIcon11=null;
		System.gc();
	}
}